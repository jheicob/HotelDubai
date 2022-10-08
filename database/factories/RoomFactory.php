<?php

namespace Database\Factories;

use App\Models\PartialCost;
use App\Models\RoomStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_status_id' => RoomStatus::factory()->create(),
            'partial_cost_id' => PartialCost::factory()->create(),
            'description' => $this->faker->text(),
            'name' => $this->faker->unique()->word()
        ];
    }
}
