<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\SeniorDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SeniorDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $seniors = Beneficiary::where('type', 'senior')->get();

        foreach ($seniors as $beneficiary) {
            SeniorDetail::create([
                'osca_id_number' => 'OSCA-' . strtoupper(Str::random(8)),
                'beneficiary_id' => $beneficiary->id,
                'ncsc_registration_number' => null,
                'place_of_birth' => "Nueva Ecija",
                'occupation' => fake()->jobTitle(),
                'pension_amount' => fake()->optional()->numberBetween(500, 2000),
            ]);
        }
    }
}
