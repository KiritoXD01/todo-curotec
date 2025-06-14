<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

test('category can be created', function () {
    $category = Category::factory()->create();

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->name)->toBeString()
        ->and($category->user_id)->toBeNull();
});

test('category belongs to a user', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['user_id' => $user->id]);

    expect($category->user)->toBeInstanceOf(User::class)
        ->and($category->user->id)->toBe($user->id);
});

test('category can have a parent category', function () {
    $parentCategory = Category::factory()->create();
    $childCategory = Category::factory()->create(['parent_id' => $parentCategory->id]);

    expect($childCategory->parent)->toBeInstanceOf(Category::class)
        ->and($childCategory->parent->id)->toBe($parentCategory->id);
});

test('category can have subcategories', function () {
    $parentCategory = Category::factory()->create();
    $subcategories = Category::factory()->count(3)->create(['parent_id' => $parentCategory->id]);

    expect($parentCategory->subcategories)->toBeInstanceOf(Collection::class)
        ->and($parentCategory->subcategories)->toHaveCount(3)
        ->and($parentCategory->subcategories->first())->toBeInstanceOf(Category::class);
});

test('category can be updated', function () {
    $category = Category::factory()->create();
    $newName = 'Updated Category Name';

    $category->update(['name' => $newName]);

    expect($category->fresh()->name)->toBe($newName);
});

test('category can be deleted', function () {
    $category = Category::factory()->create();

    $category->delete();

    expect(Category::find($category->id))->toBeNull();
});
