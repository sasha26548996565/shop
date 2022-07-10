<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyOption extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $guarded = [];

    public function property(): Relation
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }

    public function skus(): Relation
    {
        return $this->belognsToMany(Sku::class, 'sku_property_option', 'property_option_id', 'sku_id');
    }
}
