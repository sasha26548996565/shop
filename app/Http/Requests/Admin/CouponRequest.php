<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|min:6|max:8',
            'value' => 'required',
            'type' => '',
            'limit' => 'required|integer|min:1',
            'currency_id' => 'required_with:type',
            'description' => '',
            'expired_at' => ''
        ];
    }
}
