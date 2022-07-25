<?php

namespace App\ViewComposers;

use App\Services\CurrencyConvertionService;
use Illuminate\Contracts\View\View;

class CurrentCurrencySymbolComposer implements ViewComposerContract
{
    public function compose(View $view): View
    {
        return $view->with('currencySymbol', CurrencyConvertionService::getCurrencySymbol());
    }
}
