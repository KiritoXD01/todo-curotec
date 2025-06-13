<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $userId = Auth::id();

        $categories = Category::query()
            ->with('parent')
            ->where('user_id', $userId)
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

        return redirect()->back();
    }

    public function update(UpdateRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->back();
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->back();
    }
}
