<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Task;
use App\Models\User;

test('task can be created', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'user_id' => $user->id,
    ]);

    $data = Task::factory()->make([
        'category_id' => $category->id,
        'user_id' => $user->id,
    ])->toArray();

    $response = $this
        ->actingAs($user)
        ->post(route('tasks.store'), $data);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('tasks.index'));

    $task = Task::query()->first();

    expect($task)->not->toBeNull()
        ->and($task->title)->toBe($data['title'])
        ->and($task->description)->toBe($data['description'])
        ->and($task->category_id)->toBe($category->id)
        ->and($task->user_id)->toBe($user->id);
});

test('task cannot be created with non-existent category', function () {
    $user = User::factory()->create();
    $data = Task::factory()->make([
        'category_id' => 999, // Non-existent category ID
        'user_id' => $user->id,
    ])->toArray();

    $response = $this
        ->actingAs($user)
        ->post(route('tasks.store'), $data);

    $response
        ->assertSessionHasErrors(['category_id'])
        ->assertRedirect();

    expect(Task::query()->count())->toBe(0);
});
