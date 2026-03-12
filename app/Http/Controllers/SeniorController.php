<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeniorRequest;
use App\Models\SeniorDetail;
use App\Services\BeneficiaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeniorController extends Controller
{
    //

    protected $beneficiaryService;

    public function __construct(BeneficiaryService $beneficiaryService)
    {
        $this->beneficiaryService = $beneficiaryService;
    }


    public function create(){
        return view('beneficiaries/senior/create_senior');
    }

    public function store(StoreSeniorRequest $request){

        try{

            DB::transaction(function() use($request){

                $beneficiary = $this->beneficiaryService->create($request->validated(), 'senior');
            
                SeniorDetail::create([
                    'osca_id_number' => $request->pwd_id_number,
                    'benificiary_id' => $beneficiary->id,
                    'ncsc_registration_number' => $request->ncsc_registration_number,
                    'place_of_birth' => $request->place_of_birth,
                    'occupation' => $request->occupation,
                    'other_skills' => $request->other_skills ?? null,
                    'receives_pension' => $request->boolean('receives_pension') ?? false,
                    'pension_amount' => $request->pension_amount,
                    'staying_with_family' => $request->staying_with_family,
                    'living_reason' => $request->living_reason ?? null
                ]);
            });

            return redirect()->route('beneficiary.index')->with('success', 'Senior added successfully!');

        }catch(\Exception $e){
            echo('Senior Registration Failed: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Something went wrong. Please try again');
        }
    }



}
