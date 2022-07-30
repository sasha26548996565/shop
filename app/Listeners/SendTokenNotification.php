<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\TokenUpdated;
use App\Jobs\Merchats\TokenUpdateJob;

class SendTokenNotification
{
    public function handle(TokenUpdated $event)
    {
        TokenUpdateJob::dispatch($event->email, $event->token);
    }
}
