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

        if (is_null($orderId) && Order::getFullSum() < 0)
        {
            return redirect()->back();
        }

        return $next($request);
    }
}
