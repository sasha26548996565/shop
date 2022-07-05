<?php

declare(strict_types=1);

namespace App\Classes;

use App\Jobs\OrderCreateJob;
use App\Models\Order;
use App\Models\Product;
use App\Mail\OrderCreatedMail;
use App\Services\CurrencyConvertionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Relations\Pivot;

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

    public function saveOrder(string $name, string $phone, string $email): bool
    {
        if (! $this->countAvailable(true))
        {
            return false;
        }

        dispatch(new OrderCreateJob($email));

        return $this->order->saveOrder($name, $phone);
    }

    public function countAvailable(bool $updateCount = false)
    {
        $products = collect([]);

        foreach ($this->order->products as $orderProduct)
        {
            $pivotRow = $this->order->products->where('id', $orderProduct->id)->first();
            $product = Product::findOrFail($orderProduct->id);

            if ($pivotRow->countInOrder > $product->count)
                return false;

            if ($updateCount)
            {
                $orderProduct->count -= $orderProduct->countInOrder;
                $products->push($product);
            }
        }

        if ($updateCount)
            $products->map->save();

        return true;
    }

    public function addProduct(Product $product): bool
    {
        if ($this->order->products->contains($product))
        {
            $pivotRow = $this->order->products->where('id', $product->id)->first();
            if ($pivotRow->countInOrder >= $product->count)
            {
                return false;
            }

            $pivotRow->countInOrder++;
        } else
        {
            if ($product->count == 0)
            {
                return false;
            }

            $product->countInOrder = 1;
            $this->order->products->push($product);
        }

        $product = Product::findOrFail($product->id);

        return true;
    }

    public function removeProduct(Product $product): bool
    {
        if ($this->order->products->contains($product) == false)
            return false;

        $pivotRow = $this->order->products->where('id', $product->id)->first();

        if ($pivotRow->countInOrder < 2)
            $this->order->products->pop($product->id);
        else
            $pivotRow->countInOrder--;

        return true;
    }

    private function setOrder(): Order
    {
        $orderFromSession = session('order');

        if (is_null($orderFromSession))
        {
            $order = new Order();
            session(['order' => $order]);
        } else
        {
            $order = $orderFromSession;
        }

        return $order;
    }
}
