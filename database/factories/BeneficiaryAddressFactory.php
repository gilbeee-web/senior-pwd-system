<?php

namespace Database\Factories;

use App\Models\Street;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BeneficiaryAddress>
 */
class BeneficiaryAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'house_num' => $this->faker->buildingNumber,
            'street_id' => Street::inRandomOrder()->value('id'),
            'municipality' => "General Tinio",
            'province' => "Nueva Ecija",
            'zip_code' => "3104"
        ];
    }
}
