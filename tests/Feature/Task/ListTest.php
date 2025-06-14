<?php

declare(strict_types=1);

use App\Models\User;

test('tasks page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('tasks.index'));

    $response->assertOk();
});
