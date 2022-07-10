<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Property\StoreRequest;

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

        return to_route('auth.properties.index');
    }

    public function show(Property $property)
    {
        //
    }

    public function edit(Property $property): View
    {
        return view('auth.properties.form', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        //
    }

    public function destroy(Property $property)
    {
        //
    }
}
