<?php

declare(strict_types=1);

namespace App\Actions\Merchants;

use App\Models\Merchant;
use App\Events\TokenUpdated;

class TokenAction
{
    public function updateToken(Merchant $merchant): string
    {
        $token = $merchant->tokenGenerate();
        $merchant->update(['token' => hash('sha256', $token)]);
        event(new TokenUpdated($merchant->email, $token));

        return $token;
    }
}
