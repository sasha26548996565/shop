<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Merchants\TokenAction;
use App\Events\TokenUpdated;
use App\Models\Merchant;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MerchantRequest;
use Illuminate\Http\RedirectResponse;

class MerchantController extends Controller
{
    private TokenAction $tokenAction;

    public function __construct(TokenAction $tokenAction)
    {
        $this->tokenAction = $tokenAction;
    }

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
        $token = $this->tokenAction->updateToken($merchant);
        event(new TokenUpdated($merchant->email, $token));

        return to_route('admin.merchants.index');
    }
}
