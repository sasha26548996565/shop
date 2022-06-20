<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->paginate(10);

        return view('index', compact('products'));
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
