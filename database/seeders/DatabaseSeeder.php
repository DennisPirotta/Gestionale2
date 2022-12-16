<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Hour;
use App\Models\Order;
use App\Models\OrderHour;
use App\Models\TechnicalReport;
use App\Models\TechnicalReportHour;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(StaticSeeder::class);                   // Static records
        User::factory()->create([
            'name' => 'Dennis',
            'email' => 'dennispirotta@gmail.com',
            'password' => Hash::make('pellio2014'),
            'company_id' => 1,
        ]);                                                       // Dennis Account
        User::factory(3)->create();                   // Test User
        Customer::factory(5)->create();               // Test Customers
        Order::factory(30)->create();                 // Test Orders
        TechnicalReport::factory(10)->create();       // Test Technical Reports
    }
}
