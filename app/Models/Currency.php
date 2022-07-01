<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeByCode($query, string $code): Builder
    {
        //dd($query);
        return $query->where('code', $code);
    }

    public function isMain(): bool
    {
        return $this->is_main;
    }
}
