<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Events\ProductUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function store(array $params): Product
    {
        DB::beginTransaction();

        try
        {
            if (isset($params['image']))
                $params['image'] = Storage::disk('public')->put('/products', $params['image']);

            if (isset($params['property_ids']))
            {
                $propertyIds = $params['property_ids'];
                unset($params['property_ids']);
            }

            $product = Product::create($params);

            if (isset($propertyIds))
            {
                $product->properties()->sync($propertyIds);
            }

            DB::commit();

            return $product;
        } catch (\Exception $exception)
        {
            DB::rollback();
            abort(500);
        }
    }

    public function update(array $params, Product $product): Product
    {
        DB::beginTransaction();

        try
        {
            if (isset($params['image']))
            {
                if (isset($product->image))
                    Storage::delete($product->image);

                $params['image'] = Storage::disk('public')->put('/products', $params['image']);
            }

            $product->properties()->sync($params['property_ids']);
            unset($params['property_ids']);

            $product->update($params);

            DB::commit();

            return $product;
        } catch (\Exception $exception)
        {
            DB::rollback();
            abort(500);
        }
    }
}
