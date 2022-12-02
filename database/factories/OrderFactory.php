<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
use App\Models\JobType;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'innerCode' => fake()->unique()->numberBetween(20220000, 20229999),
            'outerCode' => fake()->text(8),
            'open' => fake()->date,
            'close' => fake()->date,
            'description' => fake()->text(10),
            'customer_id' => Customer::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'created_by' => User::all()->random()->id,
            'company_id' => Company::all()->random()->id,
            'country_id' => Country::all()->random()->id,
            'status_id' => Status::all()->random()->id,
            'job_type_id' => JobType::all()->random()->id,
        ];
    }
}
