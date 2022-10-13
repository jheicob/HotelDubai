<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TypeDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     * nuevo comentario
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->optional()->text()
        ];
    }
}
