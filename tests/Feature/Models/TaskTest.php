<?php

declare(strict_types=1);

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;

test('task can be created', function () {
    $task = Task::factory()->create();

    expect($task)->toBeInstanceOf(Task::class)
        ->and($task->title)->toBeString()
        ->and($task->description)->toBeString()
        ->and($task->due_date)->toBeInstanceOf(\DateTime::class)
        ->and($task->priority)->toBeInstanceOf(TaskPriorityEnum::class)
        ->and($task->status)->toBeInstanceOf(TaskStatusEnum::class);
});

test('task belongs to a user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    expect($task->user)->toBeInstanceOf(User::class)
        ->and($task->user->id)->toBe($user->id);
});

test('task belongs to a category', function () {
    $category = Category::factory()->create();
    $task = Task::factory()->create(['category_id' => $category->id]);

    expect($task->category)->toBeInstanceOf(Category::class)
        ->and($task->category->id)->toBe($category->id);
});

test('task can have a subcategory', function () {
    $subcategory = Category::factory()->create();
    $task = Task::factory()->create(['subcategory_id' => $subcategory->id]);

    expect($task->subcategory)->toBeInstanceOf(Category::class)
        ->and($task->subcategory->id)->toBe($subcategory->id);
});

test('task can be updated', function () {
    $task = Task::factory()->create();
    $newTitle = 'Updated Task Title';
    $newPriority = TaskPriorityEnum::HIGH;

    $task->update([
        'title' => $newTitle,
        'priority' => $newPriority,
    ]);

    $updatedTask = $task->fresh();
    expect($updatedTask->title)->toBe($newTitle)
        ->and($updatedTask->priority)->toBe($newPriority);
});

test('task can be deleted', function () {
    $task = Task::factory()->create();

    $task->delete();

    expect(Task::find($task->id))->toBeNull();
});

test('task has uuid', function () {
    $task = Task::factory()->create();

    expect($task->uuid)->toBeString()
        ->and(strlen($task->uuid))->toBe(36);
});

test('task status can be changed', function () {
    $task = Task::factory()->create(['status' => TaskStatusEnum::PENDING]);

    $task->update(['status' => TaskStatusEnum::COMPLETED]);

    expect($task->fresh()->status)->toBe(TaskStatusEnum::COMPLETED);
});
