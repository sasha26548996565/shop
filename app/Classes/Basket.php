<?php

declare(strict_types=1);

namespace App\Classes;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

class Basket
{
    private Order $order;

    public function __construct()
    {
        $this->order = $this->setOrder();
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function saveOrder(string $name, string $phone): bool
    {
        return $this->order->saveOrder($name, $phone);
    }

    public function addProduct(Product $product): bool
    {
        if ($this->order->products->contains($product->id))
        {
            $pivotRow = $this->getPivotRow($product->id);
            $pivotRow->increment('count', 1);

            if ($pivotRow->count > $product->count)
            {
                return false;
            }

            $pivotRow->update();
        } else
        {
            if ($product->count == 0)
            {
                return false;
            }

            $this->order->products()->attach($product->id);
        }

        $product = Product::findOrFail($product->id);

        Order::changeFullSum($product->price);

        return true;
    }

    public function removeProduct(Product $product): bool
    {
        if ($this->order->products->contains($product->id))
        {
            $pivotRow = $this->getPivotRow($product->id);

            if ($pivotRow->count < 2)
            {
                $this->order->products()->detach($product->id);
            } else
            {
                $pivotRow->decrement('count', 1);
                $pivotRow->update();
            }

            Order::changeFullSum(-$product->price);

            return true;
        }

        return false;
    }

    private function getPivotRow(int $productId): Pivot
    {
        return $this->order->products()->where('product_id', $productId)->first()->pivot;
    }

    private function setOrder(): Order
    {
        $orderId = session('orderId');

        if (is_null($orderId))
        {
            $this->order = Order::create(['user_id' => Auth::check() ? Auth::id() : null]);
            session(['orderId' => $this->order->id]);
        } else
        {
            $this->order = Order::findOr($orderId, fn () => abort(404));
        }

        return $this->order;
    }
}
