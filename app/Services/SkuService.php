<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Sku;
use App\Events\ProductUpdated;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SkuService
{
    public function store(Collection $params): void
    {
        DB::beginTransaction();

        try
        {
            $propertyIds = $params->get('property_ids' ?? null);
            $params->forget('property_ids' ?? null);

            $sku = Sku::create($params->toArray());
            $sku->propertyOptions()?->attach($propertyIds);

            DB::commit();
        } catch (\Exception $exception)
        {
            DB::rollback();
            abort(500);
        }
    }

    public function update(Collection $params, Sku $sku): void
    {
        DB::beginTransaction();

        try
        {
            $propertyIds = $params->get('property_ids' ?? null);
            $params->forget('property_ids' ?? null);

            $sku->update($params->toArray());
            event(new ProductUpdated($sku));
            $sku->propertyOptions()?->sync($propertyIds);

            DB::commit();
        } catch (\Exception $exception)
        {
            DB::rollback();
            abort(500);
        }
    }
}
