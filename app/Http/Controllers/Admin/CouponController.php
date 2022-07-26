<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use Illuminate\Http\RedirectResponse;

class CouponController extends Controller
{
    public function index(): View
    {
        $coupons = Coupon::latest()->paginate(10);

        return view('auth.coupons.index', compact('coupons'));
    }

    public function create(): View
    {
        $currencies = Currency::latest()->get();

        return view('auth.coupons.form', compact('currencies'));
    }

    public function store(CouponRequest $request): RedirectResponse
    {
        $params = $request->validated();

        foreach (['type', 'only_ones'] as $fieldName)
        {
            if (isset($params[$fieldName]))
            {
                $params[$fieldName] = 1;
            }
        }

        $coupon = Coupon::create($params);

        return to_route('admin.coupons.show', $coupon->id);
    }

    public function show(Coupon $coupon): View
    {
        return view('auth.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon): View
    {
        $currencies = Currency::latest()->get();

        return view('auth.coupons.form', compact('coupon', 'currencies'));
    }

    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $params = $request->validated();

        foreach (['type', 'only_ones'] as $fieldName)
        {
            if (isset($params[$fieldName]))
            {
                $params[$fieldName] = 1;
            } else
            {
                $params[$fieldName] = 0;
            }
        }

        $coupon->update($params);

        return to_route('admin.coupons.show', $coupon->id);
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return to_route('admin.coupons.index');
    }
}
