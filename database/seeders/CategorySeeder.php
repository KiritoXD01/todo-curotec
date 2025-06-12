<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            $users = User::query()
                ->select("id")
                ->pluck("id")
                ->all();

            foreach ($users as $user) {
                Category::factory()->count(5)->create([
                    "user_id" => $user
                ]);
            }
        }
    }
}
