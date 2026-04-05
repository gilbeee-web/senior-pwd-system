<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeniorRequest;
use App\Imports\SeniorImport;
use App\Models\Barangay;
use App\Models\SeniorDetail;
use App\Models\SeniorFamilyMember;
use App\Models\Street;
use App\Services\BeneficiaryService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SeniorController extends Controller
{
    //

    protected $beneficiaryService;

    public function __construct(BeneficiaryService $beneficiaryService)
    {
        $this->beneficiaryService = $beneficiaryService;
    }


    public function create(){

        $barangays = Barangay::all();

        return view('beneficiaries/senior/create_senior', ['barangays' => $barangays]);
    }

    public function store(StoreSeniorRequest $request){
        // dd($request->all());
        try{

            $birthdate = Carbon::parse($request->birthdate);

            if ($birthdate->age < 60) {
                return back()
                    ->withErrors(['birthdate' => 'Must be 60 years old and above to register as Senior Citizen.'])
                    ->withInput();
            }

            DB::transaction(function() use($request){

                $beneficiary = $this->beneficiaryService->create($request->validated(), 'senior');
            
                $senior = SeniorDetail::create([
                    'osca_id_number' => $request->osca_id_number,
                    'beneficiary_id' => $beneficiary->id,
                    'ncsc_registration_number' => $request->ncsc_registration_number,
                    'place_of_birth' => $request->place_of_birth,
                    'occupation' => $request->occupation,
                    'pension_amount' => $request->pension_amount ?? 0,
                    'date_id_issued' => $request->date_id_issued ?? now()
                ]);

                if($request->has('family')){

                    foreach($request->family as $member){
                        if (empty($member['full_name'])) {
                            continue;
                        }

                        SeniorFamilyMember::create([
                            'senior_detail_id' => $senior->id,
                            'full_name' => $member['full_name'],
                            'relationship' => $member['relationship'],
                            'birthdate' => $member['birthdate'],
                            'occupation' => $member['occupation'] ?? null,
                            'civil_status' => $member['civil_status'] ?? null,
                            'income' => $member['income'] ?? 0
                        ]);
                    }
                }

            });

            return redirect()->route('beneficiary.index', ['tab' => 'senior'])->with('success', 'Senior added successfully!');

        }catch(\Exception $e){
            echo('Senior Registration Failed: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Something went wrong. Please try again : ' . $e->getMessage());
        }
    }


    public function edit(SeniorDetail $senior){

        //load all the senior including its relationship
        $senior->load('beneficiary.address.street.barangay');

        $barangays = Barangay::all();

        $currentBarangayId = optional($senior->beneficiary->address->street->barangay)->id;
        
        //if current barangay_id then get all the streets
        $streets = $currentBarangayId
            ? Street::where('barangay_id', $currentBarangayId)->get()
            : collect();

        //fetch the family members in their table with foreign key senior_details_id -- load family members via relationship
        $senior->load('familyMembers');

        // dd($senior->familyMembers);

        //pension amount is in the senior_details table
        

        return view('beneficiaries/senior/edit_senior', [
            'barangays' => $barangays,
            'senior' => $senior,
            'streets' => $streets,
            'family_members' => $senior->familyMembers ?? []
        ]);
    }


    private function syncFamilyMembers(array $family, SeniorDetail $senior)
    {
        // Get existing IDs from DB
        $existingIds = $senior->familyMembers()->pluck('id')->toArray();

        // Get incoming IDs from form
        $incomingIds = collect($family)
            ->pluck('id')
            ->filter()
            ->toArray();

        // DELETE removed members
        $idsToDelete = array_diff($existingIds, $incomingIds);

        if (!empty($idsToDelete)) {
            $senior->familyMembers()->whereIn('id', $idsToDelete)->delete();
        }

        foreach ($family as $member) {

            //check if the id is existing then update
            if (isset($member['id'])) {
                $senior->familyMembers()
                    ->where('id', $member['id'])
                    ->update([
                        'full_name' => $member['full_name'],
                        'relationship' => $member['relationship'],
                        'birthdate' => $member['birthdate'],
                        'occupation' => $member['occupation'] ?? null,
                        'civil_status' => $member['civil_status'] ?? null,
                        'income' => $member['income'] ?? 0,
                    ]);
            } else {
                // CREATE new if id is not existed
                $senior->familyMembers()->create([
                    'full_name' => $member['full_name'],
                    'relationship' => $member['relationship'],
                    'birthdate' => $member['birthdate'],
                    'occupation' => $member['occupation'] ?? null,
                    'civil_status' => $member['civil_status'] ?? null,
                    'income' => $member['income'] ?? 0,
                ]);
            }
        }
    }


    public function update(StoreSeniorRequest $request, SeniorDetail $senior){

        try{

            $birthdate = Carbon::parse($request->birthdate);

            if ($birthdate->age < 60) {
                return back()
                    ->withErrors(['birthdate' => 'Must be 60 years old and above to register as Senior Citizen.'])
                    ->withInput();
            }

            DB::transaction(function() use($request, $senior){

                $this->beneficiaryService->update(
                    $senior->beneficiary,
                    $request->validated()
                );

                $senior->update([
                    'osca_id_number' => $request->osca_id_number,
                    'ncsc_registration_number' => $request->ncsc_registration_number,
                    'place_birth' => $request->place_birth,
                    'occupation' => $request->occupation,
                    'pension_amount' => $request->pension_amount ?? 0
                ]);

                $this->syncFamilyMembers($request->family ?? [], $senior);
            });

            return redirect()->route('beneficiary.index', ['tab' => 'senior'])->with('success', 'Senior Citizen updated successfully!');

        }catch(\Exception $e){
            dd('Senior Update Failed: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Something went wrong. Please try again');

        }
    }

    public function show(SeniorDetail $senior)
    {
        $senior->load('familyMembers');
        return response()->json([
            'id' => $senior->id,
            'full_name' => 
                $senior->beneficiary->last_name . ', ' .
                $senior->beneficiary->first_name . ' ' .
                $senior->beneficiary->middle_name . ' ' .
                $senior->beneficiary->suffix,
            'birthdate' => $senior->beneficiary->birthdate,
            'contact_number' => $senior->beneficiary->contact_number,
            'gender' => $senior->beneficiary->gender,
            'civil_status' => $senior->beneficiary->civil_status,
            'employment_status' => $senior->beneficiary->employment_status,
            'osca_id_number' => $senior->osca_id_number,
            'date_id_issued' => $senior->date_id_issued,
            'age' => $senior->beneficiary->birthdate
                ? Carbon::parse($senior->beneficiary->birthdate)->age
                : null,
            'street' => $senior->beneficiary->address->street->name,
            'house_num' => $senior->beneficiary->address->house_num,
            'barangay' => $senior->beneficiary->address->street->barangay->name,
            'ncsc_registration_number' => $senior->ncsc_registration_number ?? 'N/A',
            'place_of_birth' => $senior->place_of_birth,
            'occupation' => $senior->occupation ?? 'N/A',
            'pension_amount' => $senior->pension_amount ?? 'N/A',
            'date_id_issued' => $senior->date_id_issued 
                ? Carbon::parse($senior->date_id_issued)->format('m-d-Y') 
                : now()->format('m-d-Y'),
            'family_members' => $senior->familyMembers
        ]);

    }

    public function import(Request $request){

        // dd($request->all());

        try{

            $request->validate([
                'senior_file' => 'required|mimes:xlsx,xls,csv'
            ]);

            $import = new SeniorImport();

            Excel::import($import, $request->file('senior_file'));

            $report = $import->getReport();

            if ($report['skipped'] > 0 || $report['duplicate_ids'] > 0 || $report['invalid_barangay'] > 0) {
                return back()->with('report', $report);
            }

            return redirect()->route('beneficiary.index', ['tab' => 'senior'])->with('success', 'Senior data imported successfully!');

        }catch(Exception $e){
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }



}
