<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Filters\ProductFilter;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Requests\ProductFilterRequest;
use App\Services\CurrencyRatesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

class MainController extends Controller
{
    private CurrencyRatesService $currencyRatesService;
    private Product $product;

    public function __construct(Product $product, CurrencyRatesService $currencyRatesService)
    {
        $this->currencyRatesService = $currencyRatesService;
        $this->product = $product;
    }

    public function index(ProductFilterRequest $request): View
    {
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($request->validated())]);
        $products = Product::with('category')->filter($filter)->latest()->paginate(10);

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

    public function subscripe(SubscriptionRequest $request, Product $product): RedirectResponse
    {
        $email = Auth::check() ? Auth::user()->email : $request->validated()->email;

        Subscription::create(['email' => $email, 'product_id' => $product->id]);

        return redirect()->back()->with('success',  "Спасибо, мы сообщим вам когда продукт $product->name будет в наличии");
    }
}
