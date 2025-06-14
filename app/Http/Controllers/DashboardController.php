<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\Inertia;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $tasks = Task::query()
            ->where("user_id", Auth::id())
            ->select('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return Inertia::render('Dashboard', [
            'tasks' => $tasks
        ]);
    }
}
