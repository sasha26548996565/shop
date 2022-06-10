<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(): Relation
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
