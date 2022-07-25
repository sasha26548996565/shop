<?php

declare(strict_types=1);

namespace App\Classes;

use App\Models\Sku;
use App\Models\Order;
use App\Models\Product;
use App\Jobs\OrderCreateJob;
use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\CurrencyConvertionService;
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
        $skus = collect([]);

        foreach ($this->order->skus as $orderSku)
        {
            $sku = Sku::find($orderSku->id);

            if ($orderSku->countInOrder > $sku->count)
                return false;

            if ($updateCount)
            {
                $sku->count -= $orderSku->countInOrder;
                $skus->push($sku);
            }
        }

        if ($updateCount)
            $skus->map->save();

        return true;
    }

    public function addProduct(Sku $sku): bool
    {
        if ($this->order->skus->contains($sku))
        {
            $pivotRow = $this->order->skus->where('id', $sku->id)->first();

            if ($pivotRow->countInOrder >= $sku->count)
                return false;

            $pivotRow->countInOrder++;
        } else
        {
            if ($sku->count == 0)
                return false;

            $sku->countInOrder = 1;
            $this->order->skus->push($sku);
        }

        return true;
    }

    public function removeProduct(Sku $sku): bool
    {
        if ($this->order->skus->contains($sku) == false)
            return false;

        $pivotRow = $this->order->skus->where('id', $sku->id)->first();

        if ($pivotRow->countInOrder < 2)
            $this->order->skus->pop($sku->id);
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
