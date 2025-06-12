<?php

declare(strict_types=1);

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::controller(TaskController::class)
    ->middleware(['auth', 'verified'])
    ->prefix('tasks')
    ->name('tasks.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });


