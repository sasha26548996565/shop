<?php

namespace App\Mail;

use App\Models\Sku;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public readonly Sku $sku;

    public function __construct(Sku $sku)
    {
        $this->sku = $sku;
    }

    public function build()
    {
        return $this->markdown('mail.product.subscription', ['sku' => $this->sku]);
    }
}
