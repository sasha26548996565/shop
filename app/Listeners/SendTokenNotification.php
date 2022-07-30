<?php

namespace App\Listeners;

use App\Events\TokenUpdated;
use App\Mail\Merchant\ApiTokenMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Merchats\TokenUpdateJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTokenNotification
{
    public function handle(TokenUpdated $event)
    {
        TokenUpdateJob::dispatch($event->email, $event->token);
    }
}
