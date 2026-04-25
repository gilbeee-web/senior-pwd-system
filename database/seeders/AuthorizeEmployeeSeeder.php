<?php

namespace Database\Seeders;

use App\Models\AuthorizeEmployee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorizeEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $now = Carbon::now();
        
        $authorize_employees = [
            [
                'full_name' => "Sherry Ann D. Bolisay",
                'position' => "Municipal Mayor",
                'role' => "mayor",
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'full_name' => "Edgardo P. Fajardo",
                'position' => "OSCA Chairman",
                'role' => "senior_chairman",
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],

        ];

        foreach ($authorize_employees as $employee) {

            AuthorizeEmployee::where('role', $employee['role'])
                ->update(['is_active' => false]);

            AuthorizeEmployee::updateOrCreate(
                ['role' => $employee['role']],
                $employee
            );
        }



    }
}
