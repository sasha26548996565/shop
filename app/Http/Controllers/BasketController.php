<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Classes\Basket;
use App\Models\Product;
use App\Models\Sku;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class BasketController extends Controller
{

    public function index(): View
    {
        $order = (new Basket)->getOrder();

        return view('basket', compact('order'));
    }

    public function place(): View|RedirectResponse
    {
        $basket = new Basket();
        $order = $basket->getOrder();

        if (! $basket->countAvailable())
        {
            session()->flash('warning', 'Товар недоступен в большем количестве');

            return redirect()->back();
        }

        return view('order', compact('order'));
    }

    public function add(Sku $sku): RedirectResponse
    {
        $order = (new Basket)->getOrder();
        $result = (new Basket)->addProduct($sku);

        session()->flash($result ? 'successAdd' : 'errorAdd',
            $result ? 'товар добавлен в корзину' : "Товар {$sku->product->name} недоступен в большем количестве");

        return to_route('basket', compact('order'));
    }

    public function remove(Sku $sku): RedirectResponse
    {
        $order = (new Basket)->getOrder();
        (new Basket)->removeProduct($sku);

        session()->flash('successRemove', "удален продукт {$sku->product->name}");

        return to_route('basket', compact('order'));
    }

    public function confirm(Request $request): RedirectResponse
    {
        $basket = new Basket();

        if ($basket->getOrder()->hasCoupon() && !$basket->getOrder()->coupon->isAvailable())
        {
            $basket->clearCoupon();
            session()->flash('warning', __('basket.coupon.not_available'));

            return to_route('index');
        }

        $email = Auth::check() ? Auth::user()->email : $request->email;
        $result = $basket->saveOrder($request->name, $request->phone, $email);

        session()->flash($result ? 'success' : 'error',
            $result ? __('basket.you_order_confirmed') : __('basket.you_cant_order_more'));

        return to_route('index');
    }
}
