<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AddCouponRequest;

class CouponController extends Controller
{
    public function add(AddCouponRequest $request): RedirectResponse
    {
        $coupon = Coupon::where('code', $request->coupon)->first();

        if ($coupon->isAvailable())
        {
            (new Basket)->setCoupon($coupon);

            session()->flash('success', __('basket.coupon.coupon_added'));
        } else
        {
            session()->flash('error', __('basket.coupon.not_available'));
        }

        return to_route('basket');
    }
}
