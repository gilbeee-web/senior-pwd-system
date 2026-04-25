<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Beneficiary;
use App\Models\PwdDetail;
use App\Models\SeniorDetail;
use App\Models\Street;
use App\Services\BeneficiaryReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeneficiaryController extends Controller
{
    //

    public function index(Request $request, BeneficiaryReportService $service){

        // dd($request->all());

        $current_user = Auth::user();
        $barangays = Barangay::all();

        $tab = $request->tab ?? 'pwd';

        $pwd = collect();
        $senior = collect();

        if($current_user->role === 'super_admin'){
            
            $pwd = $service->getPwdQuery($request, $current_user)->paginate(5);
            
            $senior = $service->getSeniorQuery($request, $current_user)->paginate(5);
            
        }elseif($current_user->role === 'barangay_pwd_admin' || $current_user->role === 'pwd_admin'){
            $pwd = $service->getPwdQuery($request, $current_user)->paginate(5);
        }elseif($current_user->role === 'barangay_senior_admin' || $current_user->role === 'senior_admin'){
            $senior = $service->getSeniorQuery($request, $current_user)->paginate(5);
        }

        // dd($pwd);

        return view('beneficiaries/index', [
            'pwd_beneficiaries' => $pwd, 
            'senior_beneficiaries' => $senior,
            'current_user' => $current_user, 
            'barangays' => $barangays,
            'tab' => $tab
        ]);

    }


    public function getStreets(Request $request, $barangay_id){

        // dd($barangay_id);

        $streets = Street::where('barangay_id', $barangay_id)->get();

        return response()->json($streets);

    }

    public function getArchive($type){

        if ($type === 'pwd') {
            $data = PwdDetail::with('beneficiary.address')->onlyTrashed()->with('beneficiary')->get();
        } elseif ($type === 'senior') {
            $data = SeniorDetail::with('beneficiary.address')->onlyTrashed()->with('beneficiary')->get();
        } else {
            abort(404);
        }

        return view('beneficiaries/archive', ['data' => $data, 'type' => $type]);

    }



}
