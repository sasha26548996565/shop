<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Services\CurrencyConvertionService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sku extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $guarded = [];

    public function product(): Relation
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function propertyOptions(): Relation
    {
        return $this->belongsToMany(PropertyOption::class, 'sku_property_option', 'sku_id', 'property_option_id')->withTimeStamps();
    }

    public function isAvailable(): bool
    {
        return $this->count > 0;
    }

    public function getPriceForCount(): float
    {
        if (is_null($this->pivot))
            return $this->price;

        return $this->pivot->count * $this->price;
    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn(float $value) => CurrencyConvertionService::convert($value)
        );
    }
}
