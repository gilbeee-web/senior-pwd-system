<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePwdRequest;
use App\Http\Requests\UpdatePwdRequest;
use App\Imports\PwdImport;
use App\Models\ActionRequest;
use App\Models\AuthorizeEmployee;
use App\Models\Barangay;
use App\Models\PwdDetail;
use App\Models\Street;
use App\Services\BeneficiaryService;
use App\Services\UpdatePwdService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PwdController extends Controller
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

        // dd("ajajja");

        $barangays = Barangay::all();
        $current_user = Auth::user();
        $current_user_brgy = null;
        
        if($current_user->role === 'barangay_pwd_admin'){
            $current_user_brgy = Barangay::findOrFail($current_user->barangay_id);
        }
        

        return view('beneficiaries.pwd.create_pwd', [
            'barangays' => $barangays,
            'current_user_brgy' => $current_user_brgy,
            'current_user' => $current_user
        ]);
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
                    'qr_link' => $request->qr_link,
                    'is_middleclass' => $request->boolean('is_middleclass') ?? false
                ]);
            });

            return redirect()->route('beneficiary.index', ['tab' => 'pwd'])->with('success', 'PWD added successfully!');

        }catch(\Exception $e){
            return back()->withInput()->with('error', 'Something went wrong. Please try again: ' . $e->getMessage());
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
        
        // dd($pwd->educational_attainment);

        return view('beneficiaries/pwd/edit_pwd', [
            'barangays' => $barangays,
            'pwd' => $pwd,
            'streets' => $streets,
            'current_user' => Auth::user()
        ]);
    }

    public function update(UpdatePwdRequest $request, $id, UpdatePwdService $updatePwdService){

        // dd($request->all());

        $pwd = PwdDetail::findOrFail($id);
        $validated = $request->validated();

        $gracePeriodMinutes = 1; 
        $withinGracePeriod = $pwd->created_at->diffInMinutes(now()) <= $gracePeriodMinutes;

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

            'pwd' => [
                'pwd_id_number' => $validated['pwd_id_number'] ?? null,
                'disability_type' => $validated['disability_type'] ?? null,
                'guardian_name' => $validated['guardian_name'] ?? null,
                'blood_type' => $validated['blood_type'] ?? null,
                'educational_attainment' => $validated['educational_attainment'] ?? null,
                'date_id_issued' => $validated['date_id_issued'] ?? null,
                'date_id_expiration' => Carbon::parse($validated['date_id_issued'] )->addYears(5),
                'qr_link' => $validated['qr_link'] ?? null
            ]
        ];

        if($withinGracePeriod || $this->currentUserRole === 'super_admin'){
            // DB::transaction(function() use ($pwd, $payload) {

            //     // Update beneficiary
            //     $pwd->beneficiary->update($payload['beneficiary']);

            //     //Update beneficiary address
            //     $pwd->beneficiary->address->update($payload['beneficiary_address']);

            //     // Update senior
            //     $pwd->update($payload['pwd']);
            // });

            // dd($payload);

            $updatePwdService->update($pwd, $payload);

            return redirect()->route('beneficiary.index', ['tab' => 'pwd'])->with('success', 'PWD updated successfully.');
        }

        ActionRequest::create([
            'type' => 'update',
            'model_type' => PwdDetail::class,
            'model_id' => $pwd->id,
            'requested_by' => Auth::id(),
            'payload' => $payload,
            'status' => 'pending',
        ]);

        return redirect()->route('beneficiary.index', ['tab' => 'pwd'])->with('success', 'Update request submitted.');
    }



    // public function update(StorePwdRequest $request, PwdDetail $pwd){

    //     try{

    //         DB::transaction(function() use($request, $pwd){

    //             $this->beneficiaryService->update(
    //                 $pwd->beneficiary,
    //                 $request->validated()
    //             );

    //             $pwd->update([
    //                 'pwd_id_number'      => $request->pwd_id_number,
    //                 'disability_type'    => $request->disability_type,
    //                 'guardian_name'      => $request->guardian_name,
    //                 'blood_type'         => $request->blood_type,
    //                 'educational_attainment' => $request->educational_attainment,
    //                 'date_id_issued'     => $request->date_id_issued ?? today(),
    //                 'date_id_expiration' => Carbon::parse($request->date_id_issued)->addYears(5),
    //                 'is_middleclass'     => $request->boolean('is_middleclass'),
    //             ]);
    //         });

    //         return redirect()->route('beneficiary.index')->with('success', 'PWD updated successfully!');

    //     }catch(\Exception $e){
    //         dd('PWD Updated Failed: ' . $e->getMessage());
            
    //         return back()->withInput()->with('error', 'Something went wrong. Please try again');

    //     }
    // }


    public function archive(PwdDetail $pwd)
    {
        $gracePeriodMinutes = 1; 
        $withinGracePeriod = $pwd->created_at->diffInMinutes(now()) <= $gracePeriodMinutes;

        if($withinGracePeriod || $this->currentUserRole === 'super_admin' || $this->currentUserRole === 'pwd_admin'){
            $pwd->delete();

            return redirect()->route('beneficiary.index', ['tab' => 'pwd'])
                ->with('success', 'PWD record archived successfully.');
        }

        $beneficiary = $pwd->beneficiary;

        $fullName = $beneficiary
            ? trim("{$beneficiary->last_name} {$beneficiary->first_name} {$beneficiary->middle_name}")
            : 'N/A';

        ActionRequest::create([
            'type' => 'archive',
            'model_type' => PwdDetail::class,
            'model_id' => $pwd->id,
            'requested_by' => Auth::id(),
            'payload' => json_encode([
                'beneficiary_name' => $fullName,
            ]),
            'status' => 'pending',
        ]);

        return redirect()->route('beneficiary.index', ['tab' => 'pwd'])
            ->with('success', 'Archive request submitted.');
       
    }
    

    public function destroy($id)
    {
        if($this->currentUserRole !== 'super_admin' || $this->currentUserRole !== 'pwd_admin'){
            return redirect()->back()->with('error', 'Only super admin could permanently delete data.');
        }

        $pwd = PwdDetail::withTrashed()->findOrFail($id);

        $pwd->forceDelete();

        return redirect()->back()->with('success', 'PWD deleted successfully.');
    }

    public function destroyAll()
    {
        if($this->currentUserRole !== 'super_admin'){
            return redirect()->back()->with('error', "You're not allowed to perform this action.");
        }
        
        // Permanently delete ALL archived (soft deleted) records
        PwdDetail::onlyTrashed()->forceDelete();

        return redirect()->back()->with('success', 'All archived PWD records deleted permanently.');
    }

    public function restore($id)
    {
        $pwd = PwdDetail::withTrashed()->findOrFail($id);
        $pwd->restore();

        return redirect()->back()->with('success', 'PWD restored successfully.');
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
                $beneficiary->residence_status = 'active';
            }elseif($residentAction === 'inactive'){
                $beneficiary->residence_status = 'inactive';
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


    public function printPwd(Request $request){

        // dd($request->all());

        // $pwd = PwdDetail::with('beneficiary.address')->where('id', $id)->get();

        $pwd_ids = $request->selected_pwds;

        if (!$pwd_ids || count($pwd_ids) === 0) {
            return back()->with('error', 'No records selected.');
        }

        $pwds = PwdDetail::with('beneficiary')->whereIn('id', $pwd_ids)->get();
        $mayor = AuthorizeEmployee::where('role', 'mayor')->where('is_active', true)->first();

        // dd($pwd);

        return view('beneficiaries/pwd/print_pwd', ['pwd' => $pwds, 'mayor' => $mayor]);
    }




}