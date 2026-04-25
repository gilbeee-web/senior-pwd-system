<?php

namespace Database\Factories;

use App\Models\BeneficiaryAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $type = $this->faker->randomElement(['pwd', 'senior']);
        $birthdate = $type === 'senior'
            ? $this->faker->dateTimeBetween('-90 years', '-60 years')
            : $this->faker->dateTimeBetween('-59 years', '-5 years');

        return [
            'type' => $type,
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'extension' => $this->faker->optional()->randomElement(['Jr.', 'Sr.', 'III']),
            'birthdate' => $birthdate,
            'contact_number' => $this->faker->numerify('09#########'),
            'civil_status' => $this->faker->randomElement(['single','married','widowed']),
            'gender' => $this->faker->randomElement(['male','female']),
            'beneficiary_address_id' => BeneficiaryAddress::factory(),
            'life_status' => 'alive',
            'residence_status' => 'active',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
