<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request): View
    {
        $productsQuery = Product::query();

        if ($request->filled('price_from'))
        {
            $productsQuery->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to'))
        {
            $productsQuery->where('price', '<=', $request->price_to);
        }

        foreach ($this->product->getLabels() as $field => $name)
        {
            if ($request->has($field))
            {
                $productsQuery->where($field, 1);
            }
        }

        $products = $productsQuery->latest()->paginate(10);

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
