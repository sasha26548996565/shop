<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{
    use HasFactory;

    protected $guarded = [];

    private readonly int $lengthToken;

    public function __construct()
    {
        $this->lengthToken = 60;
    }

    public function createToken(): string
    {
        $token = $this->tokenGenerate($this->lengthToken);
        $this->token = hash('sha256', $token);
        $this->save();

        return $token;
    }

    private function tokenGenerate(int $lengthToken): string
    {
        return Str::random($lengthToken);
    }
}
