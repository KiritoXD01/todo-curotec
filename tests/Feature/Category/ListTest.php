<?php

declare(strict_types=1);

use App\Models\User;

test('category page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('categories.index'));

    $response->assertOk();
});
