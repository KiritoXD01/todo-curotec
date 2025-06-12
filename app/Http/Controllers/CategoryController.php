<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        $categories = Category::query()
            ->where('user_id', $user->getAuthIdentifier())
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
}
