<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        $userId = auth()->user()->getAuthIdentifier();

        $tasks = Task::query()
            ->where('user_id', $userId)
            ->latest()
            ->simplePaginate(10);

        return Inertia::render('task/Index', [
            'items' => TaskResource::collection($tasks),
        ]);
    }
}
