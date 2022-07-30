<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Merchant;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MerchantRequest;
use Illuminate\Http\RedirectResponse;

class MerchantController extends Controller
{
    public function index(): View
    {
        $merchants = Merchant::latest()->paginate(10);

        return view('auth.merchants.index', compact('merchants'));
    }

    public function create(): View
    {
        return view('auth.merchants.form');
    }

    public function store(MerchantRequest $request): RedirectResponse
    {
        $merchant = Merchant::create($request->validated());

        return to_route('admin.merchants.show', $merchant->id);
    }

    public function show(Merchant $merchant): View
    {
        return view('auth.merchants.show', compact('merchant'));
    }

    public function edit(Merchant $merchant): View
    {
        return view('auth.merchants.form', compact('merchant'));
    }

    public function update(MerchantRequest $request, Merchant $merchant): RedirectResponse
    {
        $merchant->update($request->validated());

        return to_route('admin.merchants.show', $merchant->id);
    }

    public function destroy(Merchant $merchant): RedirectResponse
    {
        $merchant->delete();

        return to_route('admin.merchants.index');
    }

    public function updateToken(Merchant $merchant): RedirectResponse
    {
        $token = $merchant->createToken();
        session()->flash('success', $token);

        return to_route('admin.merchants.index');
    }
}
