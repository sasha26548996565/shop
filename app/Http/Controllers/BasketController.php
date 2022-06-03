<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BasketController extends Controller
{
    public function basket(): View
    {
        $orderId = session('orderId');

        if ($orderId != null)
        {
            $order = Order::findOrFail($orderId);
        }

        return view('basket', compact('order'));
    }

    public function basketPlace(): View
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

        $order->products()->attach($productId);

        return to_route('basket', compact('order'));
    }
}
