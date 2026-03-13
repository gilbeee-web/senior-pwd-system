<?php

namespace App\Services\Imports;

use App\Models\PwdDetail;
use App\Services\BeneficiaryService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use function Symfony\Component\Clock\now;

class PwdImportService
{
    protected $beneficiaryService;

    public function __construct(BeneficiaryService $beneficiaryService)
    {
        $this->beneficiaryService = $beneficiaryService;
    }

    //uses this function to import file (PwdImport.php file)
    public function handle($row)
    {
        DB::transaction(function () use ($row) {
            
            // prevent the duplication of the same pwd_id_number para sa data consistency

            if(PwdDetail::where('pwd_id_number', $row['pwd_id_number'])->exists()){
                return;
            }

            //create beneficiary using service of beneficiary
            $beneficiary = $this->beneficiaryService->create([
                'last_name' => $row['last_name'],
                'first_name' => $row['first_name'],
                'middle_name' => $row['middle_name'],
                'extension' => $row['extension'],

                'birthdate' => $row['birthdate'],
                'contact_number' => $row['contact_number'],
                'civil_status' => $row['civil_status'],
                'gender' => $row['gender'],

                'house_number' => $row['house_number'],
                'street_id' => $row['street_id'],
                'municipality' => $row['municipality'],
                'province' => $row['province'],
                'zip_code' => $row['zip_code'],
            ], 'pwd'); //values and type(pwd)

            // Create PWD Details
            PwdDetail::create([
                'pwd_id_number' => $row['pwd_id_number'],
                'beneficiary_id' => $beneficiary->id,
                'disability_type' => $row['disability_type'],
                'guardian_name' => $row['guardian_name'],
                'blood_type' => $row['blood_type'],
                'educational_attainment' => $row['educational_attainment'],
                'date_id_issued' => $row['date_id_issued'] ?? now(),
                'date_id_expiration' => Carbon::parse($row['date_id_issued'])->addYears(5),
                'is_middleclass' => $row['is_middleclass'] ?? false,
            ]);


        });
    }
}