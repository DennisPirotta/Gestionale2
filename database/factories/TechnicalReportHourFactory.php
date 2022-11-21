<?php

namespace Database\Factories;

use App\Models\Hour;
use App\Models\TechnicalReport;
use App\Models\TechnicalReportHour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @extends Factory<TechnicalReportHour>
 */
class TechnicalReportHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $switch = fake()->boolean;
        return [
            'nightEU' => $switch,
            'nightXEU' => !$switch,
            'hour_id' => Hour::factory()->create([ 'hour_type_id' => 2 ]),
            'technical_report_id' => TechnicalReport::all()->random()
        ];
    }
}
