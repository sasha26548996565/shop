<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;

class Property extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $guarded = [];

    public function propertyOptions(): Relation
    {
        return $this->hasMany(PropertyOption::class, 'propery_id', 'id');
    }

    public function products(): Relation
    {
        return $this->belongsToMany(Product::class, 'property_product', 'product_id', 'property_id');
    }
}
