<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePwdRequest;
use App\Models\Barangay;
use App\Models\PwdDetail;
use App\Models\Street;
use App\Services\BeneficiaryService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    'date_id_issued' => $request->date_id_issued,
                    'date_id_expiration' => Carbon::parse($request->date_id_issued)->addYears(5),
                    'is_middleclass' => $request->boolean('is_middleclass') ?? false
                ]);
            });

            return redirect()->route('beneficiary.index')->with('success', 'PWD added successfully!');

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
                    'date_id_issued'     => $request->date_id_issued,
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
            'full_name' => $pwd->beneficiary->first_name, $pwd->beneficiary->last_name,
            'pwd_id_number' => $pwd->pwd_id_number,
            'disability_type' => $pwd->disability_type,
            'guardian_name' => $pwd->guardian_name,
            'blood_type' => $pwd->blood_type,
            'educational_attainment' => $pwd->educational_attainment,
            'date_id_issued' => $pwd->date_id_issued,
            'birthdate' => $pwd->beneficiary->birthdate,
            'age' => $pwd->beneficiary->birthdate
                ? \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->age
                : null,
        ]);

    }

}
