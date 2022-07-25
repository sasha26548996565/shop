<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\ViewComposers\CategoriesComposer;
use App\ViewComposers\PopularProductComposer;
use App\ViewComposers\CurrentCurrencyComposer;
use App\ViewComposers\CurrentCurrencySymbolComposer;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('includes.footer', CategoriesComposer::class);
        View::composer('includes.footer', PopularProductComposer::class);
        View::composer('includes.header', CurrentCurrencyComposer::class);
        View::composer('*', CurrentCurrencySymbolComposer::class);
    }
}
