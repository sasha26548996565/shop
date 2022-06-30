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
        $oldCount = $event->product->getOriginal('count');

        if ($oldCount == 0)
        {
            Subscription::sendEmailBySubscription($event->product);
        }
    }
}
