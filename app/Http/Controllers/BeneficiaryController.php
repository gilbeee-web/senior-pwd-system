<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\PwdDetail;
use App\Models\Street;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeneficiaryController extends Controller
{
    //

    public function index(){

        $pwd = PwdDetail::with('beneficiary.address')->get();

        $current_user = Auth::user();

        // dd($pwd);

        return view('beneficiaries/index', ['pwd_beneficiaries' => $pwd, 'current_user' => $current_user]);

    }


    public function getStreets(Request $request, $barangay_id){

        // dd($barangay_id);

        $streets = Street::where('barangay_id', $barangay_id)->get();

        return response()->json($streets);

    }



}
