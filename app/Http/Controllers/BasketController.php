<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Classes\Basket;
use App\Models\Product;
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

    public function place(): View
    {
        $order = (new Basket)->getOrder();

        return view('order', compact('order'));
    }

    public function add(Product $product): RedirectResponse
    {
        $order = (new Basket)->getOrder();
        (new Basket)->addProduct($product);

        session()->flash('successAdd', "продукт {$product->name} добавлен в корзину");

        return to_route('basket', compact('order'));
    }

    public function remove(Product $product): RedirectResponse
    {
        $order = (new Basket)->getOrder();
        (new Basket)->removeProduct($product);

        session()->flash('successRemove', "удален продукт {$product->name}");

        return to_route('basket', compact('order'));
    }

    public function confirm(Request $request): RedirectResponse
    {
        $result = (new Basket)->saveOrder($request->name, $request->phone);

        session()->flash($result ? 'success' : 'error',
            $result ? 'ваш заказ принят в обработку' : 'ваш заказ не принят в обработку, возникла ошибка');

        Order::eraseSum();

        return to_route('index');
    }
}
