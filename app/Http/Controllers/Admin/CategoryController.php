<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::latest()->get();

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

    public function store(Request $request): RedirectResponse
    {
        Category::create($request->all());

        return to_route('admin.categories.index');
    }

    public function edit(Category $category): View
    {
        return view('auth.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update($request->all());

        return to_route('admin.categories.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return to_route('admin.categories.index');
    }
}
