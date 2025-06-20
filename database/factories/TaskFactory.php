<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid,
            'title' => fake()->sentence(nbWords: 3),
            'description' => fake()->text(maxNbChars: 100),
            'due_date' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'priority' => fake()->randomElement(TaskPriorityEnum::cases()),
            'status' => fake()->randomElement(TaskStatusEnum::cases()),
        ];
    }
}
