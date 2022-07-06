<?php

namespace App\ViewComposers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class PopularProductComposer implements ViewComposerContract
{
    public function compose(View $view): View
    {
        $popularProductsIds = Order::latest()->get()->map->products->flatten()->map->pivot->mapToGroups(function ($pivot) {
            return [$pivot->product_id => $pivot->count];
        })->map->sum()->sortDesc()->take(3)->keys()->toArray();

        $popularProducts = Product::whereIn('id', $popularProductsIds)->get();

        return $view->with('popularProducts', $popularProducts);
    }
}
