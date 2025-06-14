<?php

declare(strict_types=1);

use App\Models\Task;
use App\Models\User;

test('task can be deleted', function () {
    $user = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route('tasks.destroy', $task));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('tasks.index'));

    expect($task->fresh())->toBeNull();
});

test('task cannot be deleted by another user', function () {
    $user = User::factory()->create();
    $another_user = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $another_user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route('tasks.destroy', $task));

    $response->assertForbidden();

    expect($task->fresh())->not()->toBeNull();
});
