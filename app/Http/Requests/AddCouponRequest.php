<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coupon' => 'required|min:6|max:8|exists:coupons,code'
        ];
    }

    public function messages()
    {
        return [
            'coupon.*' => 'Coupon does not exists'
        ];
    }
}
