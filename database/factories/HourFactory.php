<?php

namespace Database\Factories;

use App\Models\Hour;
use App\Models\HourType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hour>
 */
class HourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'count' => fake()->numberBetween(2, 10),
            'date' => fake()->unique()->dateTimeThisMonth,
            'description' => fake()->text(10),
            'hour_type_id' => HourType::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
