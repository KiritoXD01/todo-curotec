<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        $userId = Auth::id();

        $tasks = Task::query()
            ->where('user_id', $userId)
            ->with('category', 'subcategory')
            ->latest()
            ->simplePaginate(10);

        return Inertia::render('task/Index', [
            'items' => TaskResource::collection($tasks),
        ]);
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }
}
