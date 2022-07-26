<?php

namespace App\ViewComposers;

use App\Models\Sku;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class PopularProductComposer implements ViewComposerContract
{
    public function compose(View $view): View
    {
        $bestSkuIds = Order::get()->map->skus->flatten()->map->pivot->mapToGroups(function ($pivot) {
            return [$pivot->sku_id => $pivot->count];
        })->map->sum()->sortByDesc(null)->take(3)->keys()->toArray();

        $bestSkus = Sku::whereIn('id', $bestSkuIds)->get();
        return $view->with('popularSkus', $bestSkus);
    }
}
