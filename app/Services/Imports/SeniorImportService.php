<?php

namespace App\Services\Imports;

use App\Models\Barangay;
use App\Models\PwdDetail;
use App\Models\SeniorDetail;
use App\Models\Street;
use App\Services\BeneficiaryService;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

use function Symfony\Component\Clock\now;

class SeniorImportService
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

    private function formatExcelDate($value)
    {
        if (empty($value)) return null;

        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value));
        }

        return Carbon::parse($value);
    }

    //uses this function to import file (SeniorImport.php file)
    public function handle($row){

        try{

            DB::transaction(function () use ($row) {

                $seniorId = trim($row['osca_id_number']);   
                
                // prevent the duplication of the same osca_id_number para sa data consistency
                if(SeniorDetail::where('osca_id_number', $seniorId)->exists()){
                    $this->duplicate_ids++;
                    $this->skipped++;
                    return;
                }

                $birthdate = $this->formatExcelDate($row['birthdate']);

                //rejects if birthdate is equivalent to less than 60 yrs
                if (!$birthdate || $birthdate->age < 60) {
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

                    'birthdate' => $birthdate,
                    'contact_number' => $row['contact_number'],
                    'civil_status' => $row['civil_status'],
                    'employment_status' => $row['employment_status'],
                    'gender' => $row['gender'],

                    'house_num' => $row['house_number'],
                    'street_id' => $street->id,
                    'municipality' => $row['municipality'] ?? "General Tinio",
                    'province' => $row['province'] ?? "Nueva Ecija",
                    'zip_code' => $row['zip_code'] ?? "3104",
                ], 'senior'); //values and type(senior) passed in SeniorImport or in controller


                //create senior detail 
                SeniorDetail::create([
                    'osca_id_number' => $seniorId,
                    'beneficiary_id' => $beneficiary->id,
                    'ncsc_registration_number' => $row['ncsc_registration_number'] ?? 'N/A',
                    'place_of_birth' => $row['place_of_birth'] ?? 'N/A',
                    'occupation' => $row['occupation'] ?? 'N/A',
                    'pension_amount' => $row['pension_amount'] ?? 0,
                    'date_id_issued' => $row['date_id_issued']
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