<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:merchants,email'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'заполните имя',
            'email.required' => 'заполните email',
            'email.email' => 'введите корректный email',
            'email.unique' => 'такой email уже существует'
        ];
    }
}
