<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeniorRequest;
use App\Http\Requests\UpdateSeniorRequest;
use App\Imports\SeniorImport;
use App\Models\ActionRequest;
use App\Models\AuthorizeEmployee;
use App\Models\Barangay;
use App\Models\SeniorDetail;
use App\Models\SeniorFamilyMember;
use App\Models\Street;
use App\Services\BeneficiaryService;
use App\Services\UpdateSeniorService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SeniorController extends Controller
{
    //

    protected $beneficiaryService;
    protected $currentUserRole;

    public function __construct(BeneficiaryService $beneficiaryService)
    {
        $this->beneficiaryService = $beneficiaryService;
        $current_user = Auth::user();

        $this->currentUserRole = $current_user->role;
    }


    public function create(){

        $barangays = Barangay::all();
        $current_user = Auth::user();
        $current_user_brgy = null;

        if($current_user->role === 'barangay_senior_admin'){
            $current_user_brgy = Barangay::findOrFail($current_user->barangay_id);
        }
        

        return view('beneficiaries/senior/create_senior', [
            'barangays' => $barangays,
            'current_user' => $current_user,
            'current_user_brgy' => $current_user_brgy
        ]);
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

        // dd($senior);

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
            'current_user' => Auth::user(),
            'family_members' => $senior->familyMembers ?? []
        ]);
    }


    public function update(UpdateSeniorRequest $request, SeniorDetail $senior, UpdateSeniorService $updateSeniorService){

        try{
            $validated = $request->validated();

            // dd($validated);
            
            if (isset($validated['birthdate'])) {

                $birthdate = Carbon::parse($validated['birthdate']);
                $age = $birthdate->age;

                if($age < 60){
                    return back()
                        ->withErrors(['birthdate' => 'Must be 60 years old and above to register as Senior Citizen.'])
                        ->withInput();
                }
            }

            $gracePeriodMinutes = 1; 
            $withinGracePeriod = $senior->created_at->diffInMinutes(now()) <= $gracePeriodMinutes;

            $payload = [
                'beneficiary' => [
                    'first_name' => $validated['first_name'] ?? null,
                    'last_name' => $validated['last_name'] ?? null,
                    'middle_name' => $validated['middle_name'] ?? null,
                    'extension' => $validated['extension'] ?? null,
                    'birthdate' => $validated['birthdate'] ?? null,
                    'contact_number' => $validated['contact_number'] ?? null,
                    'civil_status' => $validated['civil_status'] ?? null,
                    'employment_status' => $validated['employment_status'] ?? null,
                    'gender' => $validated['gender'] ?? null
                ],

                'beneficiary_address' => [
                    'house_num' => $validated['house_num'] ?? null,
                    'barangay_id' => $validated['barangay_id'] ?? null,
                    'street_id' => $validated['street_id'] ?? null
                ],

                'senior' => [
                    'osca_id_number' => $validated['osca_id_number'] ?? null,
                    'ncsc_registration_number' => $validated['ncsc_registration_number'] ?? null,
                    'place_of_birth' => $validated['place_of_birth'] ?? null,
                    'occupation' => $validated['occupation'] ?? null,
                    'pension_amount' => $validated['pension_amount'] ?? null,
                    'date_id_issued' => $validated['date_id_issued'] ?? null,
                ],

                'family' => $validated['family'] ?? []
            ];

            if($withinGracePeriod || $this->currentUserRole === 'super_admin'){
                // DB::transaction(function () use ($senior, $payload) {

                //     $senior->beneficiary->update($payload['beneficiary']);
                //     $senior->beneficiary->address->update($payload['beneficiary_address']);
                //     $senior->update($payload['senior']);

                //     $this->syncFamilyMembers($payload['family'], $senior);
                // });

                $updateSeniorService->update($senior, $payload);

                return redirect()->route('beneficiary.index', ['tab' => 'senior'])->with('success', 'Senior updated successfully.');
            }

            ActionRequest::create([
                'type' => 'update',
                'model_type' => SeniorDetail::class,
                'model_id' => $senior->id,
                'requested_by' => Auth::id(),
                'payload' => $payload,
                'status' => 'pending',
            ]);

            return redirect()->route('beneficiary.index', ['tab' => 'senior'])->with('info', 'Update request submitted for approval.');

        }catch(Exception $e){
            return back()
            ->withInput()
            ->with('error', 'Something went wrong. Please try again: ' . $e->getMessage());
        }
    }

    // public function update(StoreSeniorRequest $request, SeniorDetail $senior){

    //     try{
            
    //         $birthdate = Carbon::parse($request->birthdate);

    //         if ($birthdate->age < 60) {
    //             return back()
    //                 ->withErrors(['birthdate' => 'Must be 60 years old and above to register as Senior Citizen.'])
    //                 ->withInput();
    //         }

    //         DB::transaction(function() use($request, $senior){

    //             $this->beneficiaryService->update(
    //                 $senior->beneficiary,
    //                 $request->validated()
    //             );

    //             $senior->update([
    //                 'osca_id_number' => $request->osca_id_number,
    //                 'ncsc_registration_number' => $request->ncsc_registration_number,
    //                 'place_birth' => $request->place_birth,
    //                 'occupation' => $request->occupation,
    //                 'pension_amount' => $request->pension_amount ?? 0
    //             ]);

    //             $this->syncFamilyMembers($request->family ?? [], $senior);
    //         });

    //         return redirect()->route('beneficiary.index', ['tab' => 'senior'])->with('success', 'Senior Citizen updated successfully!');

    //     }catch(\Exception $e){
    //         dd('Senior Update Failed: ' . $e->getMessage());
            
    //         return back()->withInput()->with('error', 'Something went wrong. Please try again');

    //     }
    // }

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

    // public function requestUpdateSenior(UpdateSeniorRequest $request, $id){

    //     $senior = SeniorDetail::findOrFail($id);
    //     $validated = $request->validated();

    //     $gracePeriodDays = 1;
    //     $withinGracePeriod = $senior->created_at->diffInDays(now()) <= $gracePeriodDays;

    //     $payload = [
    //         'beneficiary' => [
    //             'first_name' => $validated['first_name'] ?? null,
    //             'last_name' => $validated['last_name'] ?? null,
    //             'middle_name' => $validated['middle_name'] ?? null,
    //             'extension' => $validated['extension'] ?? null,
    //             'birthdate' => $validated['birthdate'] ?? null,
    //             'contact_number' => $validated['contact_number'] ?? null,
    //             'civil_status' => $validated['civil_status'] ?? null,
    //             'employment_status' => $validated['employment_status'] ?? null,
    //             'gender' => $validated['gender'] ?? null
    //         ],

    //         'beneficiary_address' => [
    //             'house_num' => $validated['house_num'] ?? null,
    //             'barangay_id' => $validated['barangay_id'] ?? null,
    //             'street_id' => $validated['street_id'] ?? null
    //         ],

    //         'senior' => [
    //             'osca_id_number' => $validated['osca_id_number'] ?? null,
    //             'ncsc_registration_number' => $validated['ncsc_registration_number'] ?? null, 
    //             'place_of_birth' => $validated['place_of_birth'] ?? null, 
    //             'occupation' => $validated['occupation'] ?? null, 
    //             'pension_amount' => $validated['pension_amount'] ?? null, 
    //             'date_id_issued' => $validated['date_id_issued'] ?? null, 
    //         ],

    //         'family' => $validated['family'] ?? []
    //     ];


    //     if($withinGracePeriod){
    //         DB::transaction(function() use ($senior, $payload) {

    //             // Update beneficiary
    //             $senior->beneficiary->update($payload['beneficiary']);

    //             // Update senior
    //             $senior->update($payload['senior']);

    //             // Sync family members
    //             $this->syncFamilyMembers($payload['family'], $senior);
    //         });

    //         return back()->with('success', 'Senior updated successfully.');
    //     }

    //     ActionRequest::create([
    //         'type' => 'update',
    //         'model_type' => SeniorDetail::class,
    //         'model_id' => $senior->id,
    //         'requested_by' => Auth::id(),
    //         'payload' => $payload,
    //         'status' => 'pending',
    //     ]);
        
    //     return back()->with('success', 'Update request submitted.');

    // }

    public function archive(SeniorDetail $senior)
    {
        // dd($this->currentUserRole);

        $gracePeriodDays = 1;
        $withinGracePeriod = $senior->created_at->diffInDays(now()) <= $gracePeriodDays;

        if($withinGracePeriod || $this->currentUserRole === 'super_admin' || $this->currentUserRole === 'senior_admin' ){
            $senior->delete();

            return redirect()->route('beneficiary.index', ['tab' => 'senior'])
                ->with('success', 'Senior record archived successfully.');
        }

        ActionRequest::create([
            'type' => 'archive',
            'model_type' => SeniorDetail::class,
            'model_id' => $senior->id,
            'requested_by' => Auth::id(),
            'payload' => null,
            'status' => 'pending',
        ]);

        return redirect()->route('beneficiary.index', ['tab' => 'senior'])->with('success', 'Archive request submitted.');
    }

    public function restore($id)
    {
        $senior = SeniorDetail::withTrashed()->findOrFail($id);
        $senior->restore();

        return redirect()->back()->with('success', 'Senior restored successfully.');
    }

    public function destroy($id)
    {
        if($this->currentUserRole !== 'super_admin' || $this->currentUserRole !== 'senior_admin'){
            return redirect()->back()->with('error', 'You are not allowed to perform this action.');
        }

        $senior = SeniorDetail::withTrashed()->findOrFail($id);

        $senior->forceDelete();

        return redirect()->back()->with('success', 'Senior deleted successfully.');
    }

    public function destroyAll()
    {
        if($this->currentUserRole !== 'super_admin'){
            return redirect()->back()->with('error', "You're not allowed to perform this action.");
        }

        // Permanently delete ALL archived (soft deleted) records
        SeniorDetail::onlyTrashed()->forceDelete();

        return redirect()->back()->with('success', 'All archived Senior Citizens records deleted permanently.');
    }

    public function printSenior(Request $request){

        // dd($request->all());
        $senior_ids = $request->selected_seniors;
        $mayor = AuthorizeEmployee::where('role', 'mayor')->where('is_active', true)->first();
        $senior_chairman = AuthorizeEmployee::where('role', 'senior_chairman')->where('is_active', true)->first();

        if (!$senior_ids || count($senior_ids) === 0) {
            return back()->with('error', 'No records selected.');
        }

        $seniors = SeniorDetail::with('beneficiary')->whereIn('id', $senior_ids)->get();

        // dd($seniors);

        return view('beneficiaries/senior/print_senior', ['senior' => $seniors, 'mayor' => $mayor, 'senior_chairman' => $senior_chairman]);
    }

    public function bulkUpdateValidate(Request $request){
        // dd($request->all());

        $senior_ids = $request->selected_seniors;

        if (!$senior_ids || count($senior_ids) === 0) {
            return back()->with('error', 'No records selected.');
        }

        //actions to apply
        $residentAction = $request->resident_action;
        $statusAction = $request->status_action;

        $seniors = SeniorDetail::with('beneficiary')->whereIn('id', $senior_ids)->get();


        foreach($seniors as $senior ){
            $beneficiary = $senior->beneficiary;

            if($residentAction === 'active'){
                $beneficiary->residence_status = 'active';
            }elseif($residentAction === 'inactive'){
                $beneficiary->residence_status = 'inactive';
            }

            if($statusAction === 'alive'){
                $beneficiary->life_status = 'alive';
            }elseif($statusAction ==='deceased'){
                $beneficiary->life_status = 'deceased';
            }

            $beneficiary->save();
            $senior->save();


        }

        return back()->with('success', 'Validated successfully.');

    }



}
