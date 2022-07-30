<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\TokenUpdated;
use App\Jobs\Merchats\SendTokenJob;

class SendTokenNotification
{
    public function handle(TokenUpdated $event)
    {
        SendTokenJob::dispatch($event->email, $event->token);
    }
}
