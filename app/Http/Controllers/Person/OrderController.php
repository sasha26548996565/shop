<?php

namespace App\Http\Controllers\Person;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Auth::user()->orders()->latest()->get();

        return view('auth.order.index', compact('orders'));
    }

    public function show(Order $order): View|RedirectResponse
    {
        if (Auth::user()->orders->contains($order))
        {
            return view('auth.order.show', compact('order'));
        }

        return redirect()->back();
    }
}
