<?php

namespace App\Services\Imports;

use App\Models\Barangay;
use App\Models\PwdDetail;
use App\Models\Street;
use App\Services\BeneficiaryService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

use function Symfony\Component\Clock\now;

class PwdImportService
{
    protected $beneficiaryService;

    public $imported = 0;
    public $skipped = 0;
    public $invalid_barangay = 0;
    public $duplicate_ids = 0;

    public function __construct(BeneficiaryService $beneficiaryService)
    {
        $this->beneficiaryService = $beneficiaryService;
    }

    //uses this function to import file (PwdImport.php file)
    public function handle($row)
    {

        try{

            DB::transaction(function () use ($row) {

                $pwdId = trim($row['pwd_id_number']);   
                
                // prevent the duplication of the same pwd_id_number para sa data consistency
                if(PwdDetail::where('pwd_id_number', $pwdId)->exists()){
                    $this->duplicate_ids++;
                    $this->skipped++;
                    return;
                }

                //find the street name and extract the id to insert in the table
                if(!empty($row['street']) && !empty($row['barangay'])){

                    $street = Street::where('name', $row['street'])->first();
                    $barangay = Barangay::where('name', $row['barangay'])->first();

                    if (!$street || !$barangay) {
                        $this->invalid_barangay++;
                        $this->skipped++;
                        return;
                        // throw new \Exception('Invalid street or barangay');
                    }
                        
                }else{
                    $this->skipped++;
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
                    'employment_status' => $row['employment_status'],
                    'gender' => $row['gender'],

                    'house_num' => $row['house_number'],
                    'barangay_id' => $barangay->id,
                    'street_id' => $street->id,
                    'municipality' => $row['municipality'] ?? "General Tinio",
                    'province' => $row['province'] ?? "Nueva Ecija",
                    'zip_code' => $row['zip_code'] ?? "3104",
                ], 'pwd'); //values and type(pwd) passed in pwdImport or in controller
                
                
                // Create PWD Details
                PwdDetail::create([
                    'pwd_id_number' => $pwdId,
                    'beneficiary_id' => $beneficiary->id,
                    'disability_type' => $row['disability_type'],
                    'guardian_name' => $row['guardian_name'],
                    'blood_type' => $row['blood_type'],
                    'educational_attainment' => $row['educational_attainment'],
                    'date_id_issued' => $row['date_id_issued'] ?? now(),
                    'date_id_expiration' => Carbon::parse($row['date_id_issued'])->addYears(5),
                    'is_middleclass' => $row['is_middleclass'] ?? false,
                ]);

                $this->imported++;

            });

        }catch(QueryException $e){
            if ($e->getCode() == 23000) {
                $this->duplicate_ids++;
                $this->skipped++;
                return;
            }

            $this->skipped++;
        }

        
    }
}