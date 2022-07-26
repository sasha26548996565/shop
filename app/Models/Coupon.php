<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order(): Relation
    {
        return $this->hasMany(Order::class, 'coupon_id', 'id');
    }

    public function currency(): Relation
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
