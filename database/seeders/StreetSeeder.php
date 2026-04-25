<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\Street;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StreetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $now = Carbon::now();

        $streets = [

            'Palale' => [
                'palale st.'
            ],

            'Bago' => [
                'Central','Gulod','Libis','Riverside','Sagingan',
                'San Marcelino','Sta. Ana','Kaagapay'
            ],

            'Nazareth' => [
                'Alarcon','Irenea','Maligaya','Sagingan',
                'Manggahana','Martin Village','Silangan'
            ],

            'Rio Chico' => [
                'Bulak/Mapedia/Sumandig','Pantay','Sibug','Buse',
                'Camia A','Camia B','Daisy','Rio Chico','Rose',
                'Sampaguita','Santan A','Santan B','Violeta'
            ],

            'Pias' => [
                'Bayukbok/Cunacon/Kalasag/Masaka/Minalungao',
                'Acacia','Banaba','Dao','Guijo','Labne',
                'Molave','Narra','Pias','Yakal','Saudi Pias/Sapang Bato'
            ],

            'Concepcion' => [
                'Atis','Bayabas','Concepcion','Enrica','Mansanas',
                'Ubas','Guyabano','Kahel','Lansones','Mangga'
            ],

            'Poblacion East' => [
                'Purok 1','Purok 2','Purok 3','Purok 4'
            ],

            'San Pedro' => [
                'Bautista St.','Bical-Bical','Bliss','Camia','Daisy','Sangka'
            ],

            'Sampaguita' => [
                'Daisy','Gumamela','Ilang-Ilang','Jasmin',
                'Orchids','Rosal','Santan'
            ],

            'Poblacion Central' => [
                'Purok 1','Purok 2','Purok 3','Purok 4','Purok 5'
            ],

            'Pulong Matong' => [
                'Purok 6','Purok 7','Purok 8','Purok 9','Purok 10','Purok 12'
            ],

            'Poblacion West' => [
                'Purok 1','Purok 2','Purok 3','Purok 4','Purok 5'
            ],

            'Padolina' => [
                'Boungainvillea','Villa Ofelia','Camia','Campupot','Dahlia',
                'Daisy','Dama de Noche','Gumamela','Ilang-Ilang','Mirasol',
                'Orchids','Rosal','Rose','Sampaguita','Santan'
            ],
        ];

        foreach ($streets as $barangayName => $streetList) {

            // get barangay id safely
            $barangay = Barangay::where('name', $barangayName)->first();

            if (!$barangay) {
                continue; // skip if not found (safe for production)
            }

            foreach ($streetList as $street) {
                Street::updateOrCreate(
                    [
                        'name' => $street,
                        'barangay_id' => $barangay->id
                    ],
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}
