<?php

namespace App\Http\Controllers;

use App\Exports\PwdReportExport;
use App\Exports\SeniorReportExport;
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

        $pwd = null;
        $senior = null;

        if($current_user->role === 'super_admin'){

            if($tab === 'pwd'){
                $pwd = $service->getPwdQuery($request, $current_user)->paginate(5);
            }

            $senior = $service->getSeniorQuery($request, $current_user)->paginate(5);

        }elseif($current_user->role === 'barangay_pwd_admin' || $current_user->role === 'pwd_admin'){
            $pwd = $service->getPwdQuery($request, $current_user)->paginate(5);
        }elseif($current_user->role === 'barangay_senior_admin' || $current_user->role === 'senior_admin'){
            $senior = $service->getSeniorQuery($request, $current_user)->paginate(5);
        }

        // dd($pwd);

        return view('reports/index', [
            'pwd_beneficiaries' => $pwd, 
            'senior_beneficiaries' => $senior,
            'current_user' => $current_user, 
            'barangays' => $barangays,
            'tab' => $tab
        ]);
    }

    public function exportPwd(Request $request){

        $current_user = Auth::user();

        return Excel::download(
            new PwdReportExport($request, $current_user),
            'pwd-report.xlsx'
        );
    }

    public function exportSenior(Request $request){

        $current_user = Auth::user();

        return Excel::download(
            new SeniorReportExport($request, $current_user),
            'senior-report.xlsx'
        );
    }


}
