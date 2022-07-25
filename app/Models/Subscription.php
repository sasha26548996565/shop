<?php

namespace App\Models;

use App\Jobs\SendSubscriptionJob;
use App\Mail\SendSubscriptionMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sku(): Relation
    {
        return $this->belongsTo(Sku::class, 'sku_id', 'id');
    }

    public function scopeActiveBySkuId($query, int $skuId): Builder
    {
        return $query->where('status', 0)->where('sku_id', $skuId);
    }

    public static function sendEmailBySubscription(Sku $sku): void
    {
        $subscriptions = self::activeBySkuId($sku->id)->get();

        foreach ($subscriptions as $subscription)
        {
            dispatch(new SendSubscriptionJob($subscription->email, $sku));

            $subscription->status = 1;
            $subscription->save();
        }
    }
}
