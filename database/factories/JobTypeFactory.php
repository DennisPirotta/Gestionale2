<?php

namespace Database\Factories;

use App\Models\JobType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobType>
 */
class JobTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->text(20),
            'title' => fake()->text(5)
        ];
    }
}
