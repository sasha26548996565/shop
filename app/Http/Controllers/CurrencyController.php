<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CurrencyController extends Controller
{
    public function switchCurrency(string $currencyCode): RedirectResponse
    {
        $currency = Currency::byCode($currencyCode)->firstOrFail();
        session(['currency' => $currency->code]);

        return redirect()->back();
    }
}
