<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TokenUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public readonly string $token;
    public readonly string $email;

    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }
}
