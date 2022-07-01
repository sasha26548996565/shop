<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Http\RedirectResponse;

class LocalizableController extends Controller
{
    private array $locales = ['ru', 'en'];

    public function switchLocale(string $locale): RedirectResponse
    {
        if (! in_array($locale, $this->locales))
        {
            $locale = config('app.locale');
        }

        session(['locale' => $locale]);
        App::setLocale($locale);

        return redirect()->back();
    }
}
