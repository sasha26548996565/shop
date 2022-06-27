<?php

namespace App\Models;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public function products(): Relation
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('count')->withTimestamps();
    }

    public static function getFullSum()
    {
        return session('full_order_sum', 0);
    }

    public static function changeFullSum($changeSum): void
    {
        $sum = self::getFullSum() + $changeSum;
        session(['full_order_sum' => $sum]);
    }

    public static function eraseSum(): void
    {
        session()->forget('full_order_sum');
    }

    public function calculateFullSum(): float
    {
        $sum = 0;

        foreach ($this->products as $product)
        {
            $sum += $product->getTotalPrice($product->pivot->count);
        }

        return $sum;
    }

    public function saveOrder($name, $phone): bool
    {
        if ($this->status == 0)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->status = 1;
            $this->save();

            session()->forget('orderId');

            return true;
        }

        return false;
    }

    public function scopeGetActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }
}
