<?php

namespace Database\Factories;

use App\Models\PartialRates;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartialCostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "room_type_id" => RoomType::factory()->create(),
            "partial_rates_id" => PartialRates::factory()->create(),
            "rate" => $this->faker->regexify('/\d{1,4}/'),
        ];
    }
}
