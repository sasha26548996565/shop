<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::latest()->paginate(10);

        return view('auth.categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        return view('auth.categories.show', compact('category'));
    }

    public function create(): View
    {
        return view('auth.categories.form');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image']))
        {
            $data['image'] = Storage::disk('public')->put('/categories', $data['image']);
        }

        Category::create($data);

        return to_route('admin.categories.index');
    }

    public function edit(Category $category): View
    {
        return view('auth.categories.form', compact('category'));
    }

    public function update(UpdateRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        if (isset($category->image) && isset($data['image']))
        {
            Storage::delete($category->image);
            $data['image'] = Storage::disk('public')->put('/categories', $data['image']);
        }

        $category->update($data);

        return to_route('admin.categories.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return to_route('admin.categories.index');
    }
}
