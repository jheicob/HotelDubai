<?php

namespace Database\Factories;

use App\Models\TypeDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document' => $this->faker->unique()->regexify('/\d{9}/'),
            'type_document_id' => TypeDocument::factory()->create(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => self::generatePhone(),
            'email' => $this->faker->email(),
        ];
    }

    private function generatePhone(){
        $companyPhone = $this->faker->randomElement(self::getCompanyPhones());
        $numberPhone = $this->faker->regexify('/\d{7}/');
        return  $companyPhone . '-' . $numberPhone;
    }

    private function getCompanyPhones(){
        return [
            '0424',
            '0414',
            '0426',
            '0416',
            '0412',
        ];
    }
}
