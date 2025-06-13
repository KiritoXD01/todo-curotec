<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Task\StoreRequest;

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

        return Inertia::render('task/Index', [
            'items' => TaskResource::collection($tasks),
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
