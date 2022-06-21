<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Filters\ProductFilter;
use Illuminate\Contracts\View\View;
use App\Http\Requests\ProductFilterRequest;

class MainController extends Controller
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(ProductFilterRequest $request): View
    {
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($request->validated())]);
        $products = Product::filter($filter)->latest()->paginate(10);

        $labels = $this->product->getLabels();

        return view('index', compact('products', 'labels'));
    }

    public function categories(): View
    {
        $categories = Category::latest()->get();

        return view('categories', compact('categories'));
    }

    public function product(string $category, string $product): View
    {
        $product = Product::where('slug', $product)->first();
        return view('product', compact('product'));
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->first();

        return view('category', compact('category'));
    }
}
