<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'purchase_price' => rand(0, 1000),
            'sale_price' => rand(0, 1000),
            'visible' => $this->faker->randomElement([true, false]),
        ];
    }
}
