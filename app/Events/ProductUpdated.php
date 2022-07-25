<?php

namespace App\Events;

use App\Models\Sku;
use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public readonly Sku $sku;

    public function __construct(Sku $sku)
    {
        $this->sku = $sku;
    }
}
