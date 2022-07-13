<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Sku;
use Illuminate\Support\Collection;

class SkuService
{
    public function store(Collection $params): void
    {
        $propertyIds = $params->get('property_ids' ?? null);
        $params->forget('property_ids' ?? null);

        $sku = Sku::create($params->toArray());
        $sku->propertyOptions()?->sync($propertyIds);
    }

    public function update(Collection $params, Sku $sku): void
    {
        $propertyIds = $params->get('property_ids' ?? null);
        $params->forget('property_ids' ?? null);

        $sku->update($params->toArray());
        $sku->propertyOptions()?->sync($propertyIds);
    }
}
