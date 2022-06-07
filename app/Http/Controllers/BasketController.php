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

            return view('basket', compact('order'));
        }

        return view('basket');
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

        if ($order->products->contains($productId))
        {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;

            $pivotRow->increment('count', 1);
            $pivotRow->update();
        } else
        {
            $order->products()->attach($productId);
        }

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

        return to_route('basket', compact('order'));
    }
}
