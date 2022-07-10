<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertyOption;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\PropertyOption\StoreRequest;
use App\Http\Requests\Admin\PropertyOption\UpdateRequest;

class PropertyOptionController extends Controller
{
    public function index(Property $property): View
    {
        $propertyOptions = PropertyOption::latest()->paginate(10);

        return view('auth.property_options.index', compact('property', 'propertyOptions'));
    }

    public function create(Property $property): View
    {
        return view('auth.property_options.form', compact('property'));
    }

    public function store(StoreRequest $request, Property $property): RedirectResponse
    {
        $params = $request->validated();
        $params['property_id'] = $property->id;

        PropertyOption::create($params);

        return to_route('admin.property-options.index', $property->id);
    }

    public function show(Property $property, PropertyOption $propertyOption): View
    {
        return view('auth.property_options.show', compact('propertyOption'));
    }

    public function edit(Property $property, PropertyOption $propertyOption): View
    {
        return view('auth.property_options.form', compact('property', 'propertyOption'));
    }

    public function update(Property $property, UpdateRequest $request, PropertyOption $propertyOption): RedirectResponse
    {
        $params = $request->validated();
        $params['property_id'] = $property->id;

        $propertyOption->update($params);

        return to_route('admin.property-options.index', $property->id);
    }

    public function destroy(Property $property, PropertyOption $propertyOption): RedirectResponse
    {
        $propertyOption->delete();

        return to_route('admin.property-options.index', $property->id);
    }
}
