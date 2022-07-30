<?php

namespace App\Http\Controllers\Api;

use App\Models\Sku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class SkuController extends Controller
{
    public function getSku(): Response
    {
        return response()->json(Sku::with('product')->latest()->get());
    }
}
