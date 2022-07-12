<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Sku;

class SkuService
{
    public function store(array $params): void
    {
        if (isset($params['property_ids']))
        {
            $propertyIds = $params['property_ids'];
            unset($params['property_ids']);
        }

        $sku = Sku::create($params);

        if (isset($propertyIds))
        {
            $sku->propertyOptions()->sync($propertyIds);
        }
    }

    public function update(array $params, Sku $sku): void
    {
        if (isset($params['property_ids']))
        {
            $propertyIds = $params['property_ids'];
            unset($params['property_ids']);
        }

        $sku->update($params);

        if (isset($propertyIds))
        {
            $sku->propertyOptions()->sync($propertyIds);
        }
    }
}
