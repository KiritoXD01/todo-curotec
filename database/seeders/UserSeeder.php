<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            User::factory()->create([
                'name' => 'Test User',
            ]);
        } else {
            User::query()->firstOrCreate(
                attributes: [
                    'email' => 'test@test.com',
                ],
                values: [
                    'name' => 'Test User',
                    'password' => 'password',
                ]);
        }
    }
}
