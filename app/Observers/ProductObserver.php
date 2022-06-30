<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function creating(Product $product): void
    {
        foreach ($product->getLabels() as $label => $name)
        {
            if (isset(request()->$label))
                $product->enableLabel($label);
        }
    }

    public function updating(Product $product): void
    {
        foreach ($product->getLabels() as $label => $name)
        {
            if (isset(request()->$label))
                $product->enableLabel($label);
            else
                $product->disableLabel($label);
        }
    }
}
