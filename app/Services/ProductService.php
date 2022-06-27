<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function store(array $data): Product
    {
        DB::beginTransaction();

        try
        {
            if (isset($data['image']))
            {
                $data['image'] = Storage::disk('public')->put('/products', $data['image']);
            }

            $product = Product::create($data);

            DB::commit();
        } catch (\Exception $exception)
        {
            DB::rollback();
            abort(500);
        }

        return $product;
    }

    public function update(array $data, Product $product): Product
    {
        DB::beginTransaction();

        try
        {
            if (isset($data['image']))
            {
                if (isset($product->image))
                {
                    Storage::delete($product->image);
                }

                $data['image'] = Storage::disk('public')->put('/products', $data['image']);
            }

            $data = $product->disableLabel($data);

            $product->update($data);

            DB::commit();
        } catch (\Exception $exception)
        {
            DB::rollback();
            abort(500);
        }

        return $product;
    }
}
