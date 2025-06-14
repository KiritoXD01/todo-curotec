<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\User;

test('category can be created', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->name)->toBeString()
        ->and($category->user_id)->toBe($user->id);
});

test('category can be created without a parent', function () {
    $user = User::factory()->create();
    $data = Category::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->post(route('categories.store'), $data);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('categories.index'));

    $category = Category::query()->first();

    expect($category->name)->toBe($data['name']);
});

test('category can be created with a parent', function () {
    $user = User::factory()->create();

    $parent_category = Category::factory()->create([
        'user_id' => $user->id,
    ]);

    $data = Category::factory()->make([
        'parent_id' => $parent_category->id,
    ])->toArray();

    $response = $this
        ->actingAs($user)
        ->post(route('categories.store'), $data);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('categories.index'));

    $category = Category::query()
        ->where('name', $data['name'])
        ->where('parent_id', $parent_category->id)
        ->first();

    expect($category)->not->toBeNull()
        ->and($category->name)->toBe($data['name'])
        ->and($category->parent_id)->toBe($parent_category->id);
});
