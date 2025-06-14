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

test('category name must be unique per user', function () {
    $user = User::factory()->create();
    $existing_category = Category::factory()->create([
        'user_id' => $user->id,
    ]);

    $data = Category::factory()->make([
        'name' => $existing_category->name,
    ])->toArray();

    $response = $this
        ->actingAs($user)
        ->post(route('categories.store'), $data);

    $response
        ->assertSessionHasErrors('name')
        ->assertRedirect();

    expect(Category::query()->where('name', $existing_category->name)->count())->toBe(1);
});

test('different users can have categories with same name', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $category1 = Category::factory()->create([
        'user_id' => $user1->id,
    ]);

    $data = Category::factory()->make([
        'name' => $category1->name,
    ])->toArray();

    $response = $this
        ->actingAs($user2)
        ->post(route('categories.store'), $data);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('categories.index'));

    expect(Category::query()->where('name', $category1->name)->count())->toBe(2);
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
