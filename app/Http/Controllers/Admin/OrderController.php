<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::latest()->paginate(10);

        return view('auth.order.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        return view('auth.order.show', compact('order'));
    }
}
