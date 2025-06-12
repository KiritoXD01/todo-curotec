<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('task/Index');
    }
}
