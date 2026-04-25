<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => "Gilbert Sta Maria",
                'role' => "super_admin",
                'password' => Hash::make('password123'),
            ]
        );

        $this->call([
            BarangaySeeder::class,
            StreetSeeder::class,
            AuthorizeEmployeeSeeder::class,

            BeneficiarySeeder::class,
            PwdDetailsSeeder::class,
            SeniorDetailsSeeder::class

        ]);

        
    }
}
