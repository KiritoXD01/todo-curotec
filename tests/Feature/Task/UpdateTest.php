<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Task;
use App\Models\User;

test('task can be updated', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'user_id' => $user->id,
    ]);
    $task = Task::factory()->create([
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    $data = Task::factory()->make([
        'category_id' => $category->id,
        'user_id' => $user->id,
    ])->toArray();

    $response = $this
        ->actingAs($user)
        ->put(route('tasks.update', $task), $data);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('tasks.index'));

    $task->refresh();

    expect($task->title)->toBe($data['title'])
        ->and($task->description)->toBe($data['description'])
        ->and($task->category_id)->toBe($category->id)
        ->and($task->user_id)->toBe($user->id);
});

test('task cannot be updated with non-existent category', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'user_id' => $user->id,
    ]);
    $task = Task::factory()->create([
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    $data = Task::factory()->make([
        'category_id' => 999, // Non-existent category ID
        'user_id' => $user->id,
    ])->toArray();

    $response = $this
        ->actingAs($user)
        ->put(route('tasks.update', $task), $data);

    $response
        ->assertSessionHasErrors(['category_id'])
        ->assertRedirect();

    $task->refresh();

    expect($task->category_id)->toBe($category->id);
});

test('task cannot be updated by another user', function () {
    $user = User::factory()->create();
    $another_user = User::factory()->create();
    $category = Category::factory()->create([
        'user_id' => $user->id,
    ]);
    $task = Task::factory()->create([
        'category_id' => $category->id,
        'user_id' => $another_user->id,
    ]);

    $data = Task::factory()->make([
        'category_id' => $category->id,
        'user_id' => $user->id,
    ])->toArray();

    $response = $this
        ->actingAs($user)
        ->put(route('tasks.update', $task), $data);

    $response->assertForbidden();

    $task->refresh();

    expect($task->title)->not->toBe($data['title']);
});
