<?php

namespace App\Mail\Merchant;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApiTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    public readonly string $apiToken;

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    public function build()
    {
        return $this->markdown('mail.merchant.api_token', ['apiToken' => $this->apiToken]);
    }
}
