<?php

namespace App\Models;

use App\Services\CurrencyConvertionService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['expired_at'];

    public function orders(): Relation
    {
        return $this->hasMany(Order::class, 'coupon_id', 'id');
    }

    public function currency(): Relation
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function isAbsolute(): bool
    {
        return $this->type;
    }

    private function issetExpiredAt(): bool
    {
        return isset($this->expired_at);
    }

    private function checkExpiredAt(): bool
    {
        return $this->issetExpiredAt() && $this->expired_at->gte(Carbon::now());
    }

    public function isAvailable(): bool
    {
        $this->refresh();
        return $this->checkExpiredAt() && $this->orders->count() < $this->limit;
    }

    public function applyCost(float $price): float
    {
        if ($this->isAbsolute())
            return $price - CurrencyConvertionService::convert($price, $this->currency->code, session()->get('currency'));
        else
            return $price - ($price * $this->value / 100);
    }
}
