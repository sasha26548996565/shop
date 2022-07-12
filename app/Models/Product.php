<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\Services\CurrencyConvertionService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Filterable, SoftDeletes, Translatable;

    protected $guarded = [];

    public function category(): Relation
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function order(): Relation
    {
        return $this->belongsTo(Order::class);
    }

    public function skus(): Relation
    {
        return $this->hasMany(Sku::class, 'sku_id', 'id');
    }

    public function properties(): Relation
    {
        return $this->belongsToMany(Property::class, 'property_product', 'product_id', 'property_id')->withTimestamps();
    }

    public function getTotalPrice(int $count): float
    {
        return $this->price * $count;
    }

    public function getPriceForCount(): float
    {
        if (is_null($this->pivot))
            return $this->price;

        return $this->pivot->count * $this->price;
    }

    public function getLabels(): array
    {
        return [
            'hit' => 'Хит',
            'newest' => 'Новинка',
            'recommend' => 'Рекомендованные'
        ];
    }



    public function issetLabel(string $labelName): bool
    {
        return $this[$labelName] == 1;
    }

    public function enableLabel(string $label): void
    {
        $this->$label = 1;
    }

    public function disableLabel(string $label): void
    {
        $this->$label = 0;
    }

    public function isAvailable(): bool
    {
        return $this->count > 0;
    }
}
