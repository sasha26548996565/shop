<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Property\StoreRequest;
use App\Http\Requests\Admin\Property\UpdateRequest;

class PropertyController extends Controller
{
    public function index(): View
    {
        $properties = Property::latest()->paginate(10);

        return view('auth.properties.index', compact('properties'));
    }

    public function create(): View
    {
        return view('auth.properties.form');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        Property::create($request->validated());

        return to_route('admin.properties.index');
    }

    public function show(Property $property): View
    {
        return view('auth.properties.show', compact('property'));
    }

    public function edit(Property $property): View
    {
        return view('auth.properties.form', compact('property'));
    }

    public function update(UpdateRequest $request, Property $property): RedirectResponse
    {
        $property->update($request->validated());

        return to_route('admin.properties.index');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->delete();

        return to_route('admin.properties.index');
    }
}
