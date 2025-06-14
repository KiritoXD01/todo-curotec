<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\User;

test('category can be updated', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'user_id' => $user->id,
    ]);

    $data = Category::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->put(route('categories.update', $category), $data);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('categories.index'));

    $category->refresh();

    expect($category->name)->toBe($data['name']);
});

test('category can be updated with a parent', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'user_id' => $user->id,
    ]);

    $parent_category = Category::factory()->create([
        'user_id' => $user->id,
    ]);

    $data = Category::factory()->make([
        'parent_id' => $parent_category->id,
    ])->toArray();

    $response = $this
        ->actingAs($user)
        ->put(route('categories.update', $category), $data);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('categories.index'));

    $category->refresh();

    expect($category->name)->toBe($data['name'])
        ->and($category->parent_id)->toBe($parent_category->id);
});

test('category cannot be updated by another user', function () {
    $user = User::factory()->create();
    $another_user = User::factory()->create();
    $category = Category::factory()->create([
        'user_id' => $another_user->id,
    ]);

    $data = Category::factory()->make()->toArray();

    $response = $this
        ->actingAs($user)
        ->put(route('categories.update', $category), $data);

    $response->assertForbidden();

    $category->refresh();

    expect($category->name)->not->toBe($data['name']);
});
