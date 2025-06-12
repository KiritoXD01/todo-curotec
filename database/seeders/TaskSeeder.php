<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            $users = User::query()
                ->select('id')
                ->pluck('id')
                ->all();

            foreach ($users as $user) {
                $categories = Category::query()
                    ->where('user_id', $user)
                    ->select('id')
                    ->pluck('id')
                    ->all();

                foreach ($categories as $category) {
                    Task::factory()
                        ->count(5)
                        ->create([
                            'user_id' => $user,
                            'category_id' => $category,
                        ]);
                }
            }
        }
    }
}
