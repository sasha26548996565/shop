<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Filters\ProductFilter;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Services\CurrencyRatesService;
use App\Http\Requests\SubscriptionRequest;
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
        $skus = Sku::with(['product', 'product.category'])->filter($filter)->latest()->paginate(10);

        $labels = $this->product->getLabels();

        return view('index', compact('skus', 'labels'));
    }

    public function categories(): View
    {
        $categories = Category::latest()->get();

        return view('categories', compact('categories'));
    }

    public function sku(string $categorySlug, string $productSlug, Sku $sku): View
    {
        abort_if($sku->product->slug != $productSlug, 404);
        abort_if($sku->product->category->slug != $categorySlug, 404);

        return view('product', compact('sku'));
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->first();

        return view('category', compact('category'));
    }

    public function subscripe(SubscriptionRequest $request, Sku $sku): RedirectResponse
    {
        $email = Auth::check() ? Auth::user()->email : $request->validated()->email;

        Subscription::create(['email' => $email, 'sku_id' => $sku->id]);

        return redirect()->back()->with('success',  "Спасибо, мы сообщим вам когда продукт {$sku->product->name} будет в наличии");
    }
}
