<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\User;

test('category can be deleted', function () {
    $user = User::factory()->create();

    $category = Category::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route('categories.destroy', $category));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('categories.index'));

    expect($category->fresh())->toBeNull();
});

test('category cannot be deleted by another user', function () {
    $user = User::factory()->create();
    $another_user = User::factory()->create();

    $category = Category::factory()->create([
        'user_id' => $another_user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route('categories.destroy', $category));

    $response->assertForbidden();

    expect($category->fresh())->not()->toBeNull();
});
