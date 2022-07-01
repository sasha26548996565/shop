<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'name_en' => 'required',
            'description_en' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'image' => ''
        ];
    }
}
