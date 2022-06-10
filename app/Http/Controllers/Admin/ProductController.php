<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->get();

        return view('auth.products.index', compact('products'));
    }

    public function show(Product $product): View
    {
        return view('auth.products.show', compact('product'));
    }

    public function create(): View
    {
        $categories = Category::latest()->get();

        return view('auth.products.form', compact('categories'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image']))
        {
            $data['image'] = Storage::disk('public')->put('/products', $data['image']);
        }

        $product = Product::create($data);

        return to_route('admin.products.show', ['product' => $product->id]);
    }

    public function edit(Product $product): View
    {
        $categories = Category::latest()->get();

        return view('auth.products.form', compact('categories', 'product'));
    }

    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image']) && isset($product->image))
        {
            Storage::delete($data['image']);
            $data['image'] = Storage::disk('public')->put('/products', $data['image']);
        }

        $product->update($data);

        return to_route('admin.products.show', ['product' => $product->id]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return to_route('admin.products.index');
    }
}
