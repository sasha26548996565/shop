<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\ViewComposers\CategoriesComposer;
use App\ViewComposers\PopularProductComposer;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('includes.footer', CategoriesComposer::class);
        View::composer('includes.footer', PopularProductComposer::class);
    }
}
