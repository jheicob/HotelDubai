<?php

namespace Database\Factories;

use App\Models\DayWeek;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DayTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_type_id' => RoomType::factory()->create(),
            'day_week_id'  => DayWeek::factory()->create(),
            'rate'         => $this->faker->numberBetween(-100,100),
        ];
    }
}
