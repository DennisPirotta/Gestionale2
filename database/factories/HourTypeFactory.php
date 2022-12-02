<?php

namespace Database\Factories;

use App\Models\HourType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HourType>
 */
class HourTypeFactory extends Factory
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
        ];
    }
}
