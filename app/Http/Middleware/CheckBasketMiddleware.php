<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckBasketMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $order = session('order');

        if (! is_null($order) && $order->getFullSum() > 0)
        {
            return $next($request);
        }

        session()->forget('order');
        return to_route('index');
    }
}
