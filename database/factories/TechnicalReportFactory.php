<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\TechnicalReport;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TechnicalReport>
 */
class TechnicalReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->numberBetween(100000, 999999),
            'order_id' => Order::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'customer_id' => Customer::all()->random()->id,
            'secondary_customer_id' => random_int(0, 1) === 1 ? null : Customer::all()->random()->id,
        ];
    }
}
