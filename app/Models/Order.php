<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Builder;
use App\Services\CurrencyConvertionService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(): Relation
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('count')->withTimestamps();
    }

    public function currency(): Relation
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function getFullSum(): float
    {
        $sum = 0;

        foreach ($this->products as $product)
            $sum += $product->price * $product->countInOrder;

        return $sum;
    }

    public function saveOrder(string $name, string $phone): bool
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->sum = $this->getFullSum();
        $this->status = 1;
        $this->user_id = Auth::check() ? Auth::user()->id : null;
        $this->currency_id = CurrencyConvertionService::getCurrentCurrencyFromSession()->id;

        $products = $this->products;
        $this->save();

        $this->updateProduct($products);

        session()->forget('order');

        return true;
    }

    private function updateProduct($products): void
    {
        foreach ($products as $productInOrder)
        {
            $this->products()->attach($productInOrder, [
                'count' => $productInOrder->countInOrder,
                'price' => $productInOrder->price
            ]);
        }
    }

    public function scopeGetActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }
}
