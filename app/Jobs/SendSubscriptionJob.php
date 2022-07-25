<?php

namespace App\Jobs;

use App\Models\Sku;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use App\Mail\SendSubscriptionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $email;
    private Sku $sku;

    public function __construct(string $email, Sku $sku)
    {
        $this->email = $email;
        $this->sku = $sku;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new SendSubscriptionMail($this->sku));
    }
}
