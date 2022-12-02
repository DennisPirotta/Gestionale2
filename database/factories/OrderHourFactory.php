<?php

namespace Database\Factories;

use App\Models\Hour;
use App\Models\JobType;
use App\Models\Order;
use App\Models\OrderHour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderHour>
 */
class OrderHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::all()->random(),
            'hour_id' => Hour::factory()->create(['hour_type_id' => 1]),
            'job_type_id' => JobType::all()->random(),
            'signed' => fake()->boolean,
        ];
    }
}
