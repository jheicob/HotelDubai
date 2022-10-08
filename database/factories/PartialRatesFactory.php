<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PartialRatesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->randomDigit() . 'h',
            'name' => $this->faker->unique()->randomDigit() . 'h',
        ];
    }
}
