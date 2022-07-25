<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductEmailNotification
{
    public function handle(ProductUpdated $event)
    {
        if ($event->sku->count > 0)
        {
            Subscription::sendEmailBySubscription($event->sku);
        }
    }
}
