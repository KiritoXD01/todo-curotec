<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoryController::class)
    ->prefix('categories')
    ->name('categories.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });
