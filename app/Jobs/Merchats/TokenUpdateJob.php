<?php

declare(strict_types=1);

namespace App\Jobs\Merchats;

use Illuminate\Bus\Queueable;
use App\Mail\Merchant\ApiTokenMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TokenUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private readonly string $email;
    private readonly string $token;

    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new ApiTokenMail($this->token));
    }
}
