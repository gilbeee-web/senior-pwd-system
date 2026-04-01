<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePwdRequest;
use App\Imports\PwdImport;
use App\Models\Barangay;
use App\Models\PwdDetail;
use App\Models\Street;
use App\Services\BeneficiaryService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PwdController extends Controller
{
    //

    protected $beneficiaryService;

    public function __construct(BeneficiaryService $beneficiaryService)
    {
        $this->beneficiaryService = $beneficiaryService;
    }


    public function create(){

        $barangays = Barangay::all();

        return view('beneficiaries/pwd/create_pwd', ['barangays' => $barangays]);
    }

    public function store(StorePwdRequest $request){
        // dd("Store reached");
        // dd($request->all());

        try{

            DB::transaction(function() use($request){

                $beneficiary = $this->beneficiaryService->create($request->validated(), 'pwd');
            
                PwdDetail::create([
                    'pwd_id_number' => $request->pwd_id_number,
                    'beneficiary_id' => (int) $beneficiary->id,
                    'disability_type' => $request->disability_type,
                    'guardian_name' => $request->guardian_name,
                    'blood_type' => $request->blood_type,
                    'educational_attainment' => $request->educational_attainment,
                    'date_id_issued' => $request->date_id_issued ?? today(),
                    'date_id_expiration' => Carbon::parse($request->date_id_issued)->addYears(5),
                    'is_middleclass' => $request->boolean('is_middleclass') ?? false
                ]);
            });

            return redirect()->route('beneficiary.index', ['tab' => 'pwd'])->with('success', 'PWD added successfully!');

        }catch(\Exception $e){
            dd('PWD Registration Failed: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Something went wrong. Please try again');

        }
    }

    public function edit(PwdDetail $pwd){

        //load all the pwd including its relationship
        $pwd->load('beneficiary.address.street.barangay');

        $barangays = Barangay::all();

        $currentBarangayId = optional($pwd->beneficiary->address->street->barangay)->id;
        
        //if current barangay_id then get all the streets
        $streets = $currentBarangayId
            ? Street::where('barangay_id', $currentBarangayId)->get()
            : collect();
        

        return view('beneficiaries/pwd/edit_pwd', [
            'barangays' => $barangays,
            'pwd' => $pwd,
            'streets' => $streets
        ]);
    }



    public function update(StorePwdRequest $request, PwdDetail $pwd){

        try{

            DB::transaction(function() use($request, $pwd){

                $this->beneficiaryService->update(
                    $pwd->beneficiary,
                    $request->validated()
                );

                $pwd->update([
                    'pwd_id_number'      => $request->pwd_id_number,
                    'disability_type'    => $request->disability_type,
                    'guardian_name'      => $request->guardian_name,
                    'blood_type'         => $request->blood_type,
                    'educational_attainment' => $request->educational_attainment,
                    'date_id_issued'     => $request->date_id_issued ?? today(),
                    'date_id_expiration' => Carbon::parse($request->date_id_issued)->addYears(5),
                    'is_middleclass'     => $request->boolean('is_middleclass'),
                ]);
            });

            return redirect()->route('beneficiary.index')->with('success', 'PWD updated successfully!');

        }catch(\Exception $e){
            dd('PWD Updated Failed: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Something went wrong. Please try again');

        }
    }


    public function archive(PwdDetail $pwd)
    {
        $pwd->delete();

        return redirect()->route('beneficiary.index')
            ->with('success', 'PWD record archived successfully.');
    }
    

    public function destroy($id)
    {
        $pwd = PwdDetail::withTrashed()->findOrFail($id);

        $pwd->forceDelete();

        return redirect()->route('beneficiary.index')
            ->with('success', 'PWD deleted successfully.');
    }

    public function restore($id)
    {
        $pwd = PwdDetail::withTrashed()->findOrFail($id);
        $pwd->restore();
    }



    public function show(PwdDetail $pwd)
    {

        return response()->json([
            'id' => $pwd->id,
            'full_name' => 
                $pwd->beneficiary->last_name . ', ' .
                $pwd->beneficiary->first_name . ' ' .
                $pwd->beneficiary->middle_name . ' ' .
                $pwd->beneficiary->suffix,
            'birthdate' => $pwd->beneficiary->birthdate,
            'contact_number' => $pwd->beneficiary->contact_number,
            'gender' => $pwd->beneficiary->gender,
            'civil_status' => $pwd->beneficiary->civil_status,
            'employment_status' => $pwd->beneficiary->employment_status,
            'pwd_id_number' => $pwd->pwd_id_number,
            'disability_type' => $pwd->disability_type,
            'guardian_name' => $pwd->guardian_name,
            'blood_type' => $pwd->blood_type,
            'educational_attainment' => $pwd->educational_attainment,
            'date_id_issued' => $pwd->date_id_issued,
            'birthdate' => $pwd->beneficiary->birthdate,
            'age' => $pwd->beneficiary->birthdate
                ? Carbon::parse($pwd->beneficiary->birthdate)->age
                : null,
            'street' => $pwd->beneficiary->address->street->name,
            'house_num' => $pwd->beneficiary->address->house_num,
            'barangay' => $pwd->beneficiary->address->street->barangay->name
        ]);

    }



    public function import(Request $request){

        // dd($request->all());

        try{
            $request->validate([
                'pwd_file' => 'required|mimes:xlsx,xls,csv'
            ]);

            $import = new PwdImport();

            Excel::import($import, $request->file('pwd_file'));

            $report = $import->getReport();

            if ($report['skipped'] > 0 || $report['duplicate_ids'] > 0 || $report['invalid_barangay'] > 0) {
                return back()->with('report', $report);
            }

            return back()->with('success', 'PWD data imported successfully!');

        }catch(Exception $e){
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }


    public function bulkUpdateValidate(Request $request){
        // dd($request->all());

        $pwd_ids = $request->selected_pwds;

        if (!$pwd_ids || count($pwd_ids) === 0) {
            return back()->with('error', 'No records selected.');
        }

        //actions to apply
        $residentAction = $request->resident_action;
        $statusAction = $request->status_action;
        $incomeAction = $request->income_action;

        $pwds = PwdDetail::with('beneficiary')->whereIn('id', $pwd_ids)->get();

        // dd($pwds);

        foreach($pwds as $pwd ){
            $beneficiary = $pwd->beneficiary;

            if($residentAction === 'active'){
                $beneficiary->resident_status = 'active';
            }elseif($residentAction === 'inactive'){
                $beneficiary->resident_status = 'inactive';
            }

            if($statusAction === 'alive'){
                $beneficiary->life_status = 'alive';
            }elseif($statusAction ==='deceased'){
                $beneficiary->life_status = 'deceased';
            }

            if($incomeAction === 'below'){
                $pwd->is_middleclass = 0;
            }elseif($incomeAction === 'above'){
                $pwd->is_middleclass = 1;
            }

            $beneficiary->save();
            $pwd->save();


        }

        return back()->with('success', 'Validated successfully.');

    }

}
