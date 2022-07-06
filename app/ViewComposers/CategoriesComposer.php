<?php

namespace App\ViewComposers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class CategoriesComposer implements ViewComposerContract
{
    public function compose(View $view): View
    {
        return $view->with('categories', Category::latest()->get());
    }
}
