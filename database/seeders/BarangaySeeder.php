<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();

        $barangays = [
            'Padolina',
            'Poblacion West',
            'Pulong Matong',
            'Poblacion Central',
            'Sampaguita',
            'San Pedro',
            'Poblacion East',
            'Concepcion',
            'Rio Chico',
            'Pias',
            'Nazareth',
            'Bago',
            'Palale',
        ];

        foreach ($barangays as $brgy) {
            Barangay::updateOrCreate(
                ['name' => $brgy],
                [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
        
    }
}
