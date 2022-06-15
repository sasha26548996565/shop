<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckBasketMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $orderId = session('orderId');

        if (is_null($orderId))
        {
            return redirect()->back();
        }

        $order = Order::findOrFail($orderId);

        if ($order->products->count() == 0)
        {
            session()->flash('basketEmpty', 'Ваша корзина пуста');

            return to_route('index');
        }

        return $next($request);
    }
}
