<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TaskResource;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        $user_id = Auth::id();

        $tasks = Task::query()
            ->where('user_id', $user_id)
            ->with('category', 'subcategory')
            ->latest()
            ->simplePaginate(10);

        $categories = Category::query()
            ->where("user_id", $user_id)
            ->select("id", "name", "parent_id")
            ->get();

        return Inertia::render('task/Index', [
            'items' => TaskResource::collection($tasks),
            'categories' => $categories
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $request->user()->tasks()->create($data);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }
}
