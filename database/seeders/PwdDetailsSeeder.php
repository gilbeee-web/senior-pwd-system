<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\PwdDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PwdDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $pwds = Beneficiary::where('type', 'pwd')->get();
        

        foreach ($pwds as $beneficiary) {

            $issuedDate = now()->subYears(rand(1, 5));

            PwdDetail::create([
                'pwd_id_number' => 'PWD-' . strtoupper(Str::random(8)),
                'beneficiary_id' => $beneficiary->id,
                'disability_type' => fake()->randomElement([
                    'Physical','Visual','Hearing','Mental','Speech', 'Rare'
                ]),
                'guardian_name' => fake()->name(),
                'blood_type' => fake()->randomElement(['A','B','AB','O']),
                'educational_attainment' => fake()->randomElement([
                    'Elementary','High School','College'
                ]),
                'date_id_issued' => $issuedDate,
                'date_id_expiration' => (clone $issuedDate)->addYears(5),
                'is_middleclass' => fake()->boolean(),
            ]);
        }
    }
}
