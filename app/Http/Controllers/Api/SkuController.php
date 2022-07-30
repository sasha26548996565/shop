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
        $sku = Sku::with('product')->available()->latest()->get();

        return response()->json($sku);
    }
}
