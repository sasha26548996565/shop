<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class BasketController extends Controller
{
    public function index(): View
    {
        $orderId = session('orderId');

        if ($orderId != null)
        {
            $order = Order::findOrFail($orderId);

            return view('basket', compact('order'));
        }

        return view('basket');
    }

    public function place(): View
    {
        return view('order');
    }

    public function add(int $productId): RedirectResponse
    {
        $orderId = session('orderId');


        if (is_null($orderId))
        {
            $order = Order::create();
            session(['orderId' => $order->id]);
        } else
        {
            $order = Order::findOr($orderId, fn () => abort(404));
        }

        if ($order->products->contains($productId))
        {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;

            $pivotRow->increment('count', 1);
            $pivotRow->update();
        } else
        {
            $order->products()->attach($productId);
        }

        if (Auth::check())
        {
            $order->user_id = Auth::id();
            $order->save();
        }

        $product = Product::findOrFail($productId);

        Order::changeFullSum($product->price);

        session()->flash('successAdd', "продукт {$product->name} добавлен в корзину");

        return to_route('basket', compact('order'));
    }

    public function remove(int $productId): RedirectResponse
    {
        $orderId = session('orderId');

        if (is_null($orderId))
        {
            return to_route('basket');
        }

        $order = Order::findOrFail($orderId);

        if ($order->products->contains($productId))
        {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;

            if ($pivotRow->count < 2)
            {
                $order->products()->detach($productId);
            } else
            {
                $pivotRow->decrement('count', 1);
                $pivotRow->update();
            }
        }

        $product = Product::findOrFail($productId);

        Order::changeFullSum(-$product->price);

        session()->flash('successRemove', "удален продукт {$product->name}");

        return to_route('basket', compact('order'));
    }

    public function confirm(Request $request): RedirectResponse
    {
        $orderId = session('orderId');

        if (is_null($orderId))
        {
            return to_route('index');
        }

        $order = Order::findOrFail($orderId);
        $result = $order->saveOrder($request->name, $request->phone);

        session()->flash($result ? 'success' : 'error',
            $result ? 'ваш заказ принят в обработку' : 'ваш заказ не принят в обработку, возникла ошибка');

        Order::eraseSum();

        return to_route('index');
    }
}
