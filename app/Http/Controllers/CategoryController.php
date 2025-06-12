<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        $categories = Category::query()
            ->whereBelongsTo($user)
            ->latest()
            ->paginate(10);

        return Inertia::render('category/Index', [
            'categories' => CategoryResource::collection($categories),
        ]);
    }
}
