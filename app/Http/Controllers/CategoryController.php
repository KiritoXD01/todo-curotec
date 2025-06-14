<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $user_id = Auth::id();

        $categories = Category::query()
            ->with('parent')
            ->where('user_id', $user_id)
            ->latest()
            ->simplePaginate(10);

        return Inertia::render('category/Index', [
            'items' => CategoryResource::collection($categories),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $request->user()->categories()->create($data);

        return redirect()->route('categories.index');
    }

    public function update(UpdateRequest $request, Category $category): RedirectResponse
    {
        Gate::authorize('update', $category);
        
        $category->update($request->validated());

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
