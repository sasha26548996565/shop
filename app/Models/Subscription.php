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

    public function product(): Relation
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function scopeActiveByProductId($query, int $productId): Builder
    {
        return $query->where('status', 0)->where('product_id', $productId);
    }

    public static function sendEmailBySubscription(Product $product): void
    {
        $subscriptions = self::activeByProductId($product->id)->get();

        foreach ($subscriptions as $subscription)
        {
            dispatch(new SendSubscriptionJob($subscription->email, $product));

            $subscription->status = 1;
            $subscription->save();
        }
    }
}
