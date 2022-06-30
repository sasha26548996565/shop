<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\SendSubscriptionMail;
use App\Models\Product;
use App\Models\Subscription;
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
    private Product $product;

    public function __construct(string $email, Product $product)
    {
        $this->email = $email;
        $this->product = $product;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new SendSubscriptionMail($this->product));
    }
}
