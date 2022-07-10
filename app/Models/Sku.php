<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Sku extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product(): Relation
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function skus(): Relation
    {
        return $this->belognsToMany(PropertyOption::class, 'sku_property_option', 'sku_id', 'property_option_id');
    }
}
