<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    private ProductService $service;
    private Product $product;

    public function __construct(Product $product, ProductService $service)
    {
        $this->service = $service;
        $this->product = $product;
    }

    public function index(): View
    {
        $products = Product::latest()->paginate(10);

        return view('auth.products.index', compact('products'));
    }

    public function show(Product $product): View
    {
        return view('auth.products.show', compact('product'));
    }

    public function create(): View
    {
        $categories = Category::latest()->get();
        $labels = $this->product->getLabels();

        return view('auth.products.form', compact('categories', 'labels'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $product = $this->service->store($request->validated());

        return to_route('admin.products.show', ['product' => $product->id]);
    }

    public function edit(Product $product): View
    {
        $categories = Category::latest()->get();
        $labels = $this->product->getLabels();

        return view('auth.products.form', compact('categories', 'product', 'labels'));
    }

    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        $product = $this->service->update($request->validated(), $product);

        return to_route('admin.products.show', ['product' => $product->id]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return to_route('admin.products.index');
    }
}
