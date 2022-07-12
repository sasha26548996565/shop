<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sku;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Sku\StoreRequest;
use App\Http\Requests\Admin\Sku\UpdateRequest;
use App\Services\SkuService;

class SkuController extends Controller
{
    private SkuService $skuService;

    public function __construct(SkuService $skuService)
    {
        $this->skuService = $skuService;
    }

    public function index(Product $product): View
    {
        $skus = Sku::latest()->paginate(10);

        return view('auth.skus.index', compact('skus', 'product'));
    }

    public function create(Product $product): View
    {
        return view('auth.skus.form', compact('product'));
    }

    public function store(StoreRequest $request, Product $product): RedirectResponse
    {
        $params = $request->validated();
        $params['product_id'] = $product->id;

        $this->skuService->store($params);

        return to_route('admin.skus.index', $product->id);
    }

    public function show(Product $product, Sku $sku): View
    {
        return view('auth.skus.show', compact('product', 'sku'));
    }

    public function edit(Product $product, Sku $sku): View
    {
        return view('auth.skus.form', compact('product', 'sku'));
    }

    public function update(UpdateRequest $request, Product $product, Sku $sku): RedirectResponse
    {
        $params = $request->validated();
        $params['product_id'] = $product->id;

        $this->skuService->update($params, $sku);

        return to_route('admin.skus.index', $product->id);
    }

    public function destroy(Product $product, Sku $sku): RedirectResponse
    {
        $sku->delete();

        return to_route('admin.skus.index', $product->id);
    }
}
