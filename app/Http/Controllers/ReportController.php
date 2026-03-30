<?php

namespace App\Http\Controllers;

use App\Exports\PwdReportExport;
use App\Models\Barangay;
use App\Services\BeneficiaryReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //

    public function index(Request $request, BeneficiaryReportService $service){

        $current_user = Auth::user();
        $barangays = Barangay::all();

        $tab = $request->tab ?? 'pwd';

        $pwd = collect();
        $senior = collect();

        if($current_user->role === 'super_admin'){
            if($tab === 'pwd'){
                $pwd = $service->getPwdQuery($request, $current_user)->get();
            }elseif($tab === 'senior'){
                $senior = $service->getSeniorQuery($request, $current_user)->get();
            }
        }elseif($current_user->role === 'barangay_pwd_admin'){
            $pwd = $service->getPwdQuery($request, $current_user)->get();
        }elseif($current_user->role === 'barangay_senior_admin'){
            $senior = $service->getSeniorQuery($request, $current_user)->get();
        }

        // dd($pwd);

        return view('reports/index', [
            'pwd_beneficiaries' => $pwd, 
            'senior_beneficiaries' => $senior,
            'current_user' => $current_user, 
            'barangays' => $barangays
        ]);
    }

    public function exportPwd(Request $request){

        $current_user = Auth::user();

        return Excel::download(
            new PwdReportExport($request, $current_user),
            'pwd-report.xlsx'
        );
    }


}
