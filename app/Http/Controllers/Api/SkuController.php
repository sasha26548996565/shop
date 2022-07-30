<?php

namespace App\Http\Controllers\Api;

use App\Models\Sku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkuController extends Controller
{
    public function getSku()
    {
        return Sku::with('product')->latest()->get();
    }
}
