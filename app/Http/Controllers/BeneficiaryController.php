<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Beneficiary;
use App\Models\PwdDetail;
use App\Models\SeniorDetail;
use App\Models\Street;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeneficiaryController extends Controller
{
    //

    public function index(Request $request){

        // dd($request->all());

        $current_user = Auth::user();
        $barangays = Barangay::all();

        $tab = $request->tab ?? 'pwd';
        $search = $request->search;
        $barangay = $request->barangay;
        $disability = $request->disability_type;
        $seniorType = $request->senior_type;

        $pwdQuery = PwdDetail::with('beneficiary.address');
        $seniorQuery = SeniorDetail::with('beneficiary.address');

        if($tab === 'pwd'){

            //search by first and last name or id number
            if($search){
                $pwdQuery->where(function ($q) use ($search) {
                    $q->where('pwd_id_number', 'like', "%{$search}%")
                    ->orWhereHas('beneficiary', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                    });
                });
            }

            // filter by DISABILITY TYPE
            if ($disability) {
                $pwdQuery->where('disability_type', $disability);
            }

            // filter by BARANGAY
            if ($barangay) {
                $pwdQuery->whereHas('beneficiary.address', function ($q) use ($barangay) {
                    $q->where('barangay_id', $barangay);
                });
            }
        }

        if($tab === 'senior'){

            //search by first and last name or id number
            if($search){
                $seniorQuery->where(function ($q) use ($search) {
                    $q->where('osca_id_number', 'like', "%{$search}%")
                    ->orWhereHas('beneficiary', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                    });
                });
            }

            //filter by senior type that based on their computed age from birthdate
            if ($seniorType) {
                $seniorQuery->whereHas('beneficiary', function ($q) use ($seniorType) {
                    $today = Carbon::today()->format('Y-m-d');

                    $q->where(function ($q2) use ($seniorType, $today) {
                        if ($seniorType === 'Senior') {
                            $q2->whereBetween(DB::raw("TIMESTAMPDIFF(YEAR, birthdate, '$today')"), [60, 79]);
                        } elseif ($seniorType === 'Octogenarian') {
                            $q2->whereBetween(DB::raw("TIMESTAMPDIFF(YEAR, birthdate, '$today')"), [80, 89]);
                        } elseif ($seniorType === 'Nonagenarian') {
                            $q2->whereBetween(DB::raw("TIMESTAMPDIFF(YEAR, birthdate, '$today')"), [90, 99]);
                        } elseif ($seniorType === 'Centenarian') {
                            $q2->where(DB::raw("TIMESTAMPDIFF(YEAR, birthdate, '$today')"), '>=', 100);
                        }
                    });
                });
            }

        }


        $pwd = collect();
        $senior = collect();

        if($current_user->role === 'super_admin'){
            $pwd = $pwdQuery->get();
            $senior = $seniorQuery->get();
        }elseif($current_user->role === 'barangay_pwd_admin'){
            $pwd = $pwdQuery->get();
        }elseif($current_user->role === 'barangay_senior_admin'){
            $senior = $seniorQuery->get();
        }


        // dd($pwd);

        return view('beneficiaries/index', [
            'pwd_beneficiaries' => $pwd, 
            'senior_beneficiaries' => $senior,
            'current_user' => $current_user, 
            'barangays' => $barangays
        ]);

    }


    public function getStreets(Request $request, $barangay_id){

        // dd($barangay_id);

        $streets = Street::where('barangay_id', $barangay_id)->get();

        return response()->json($streets);

    }



}
