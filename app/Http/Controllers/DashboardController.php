<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Beneficiary;
use App\Models\PwdDetail;
use App\Models\SeniorDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //

     
    protected $currentUser;

    public function __construct()
    {
        $this->currentUser = Auth::user();
    }

    private function buildDashboardData($type)
    {
        //filter first to just senior type data
        $baseQuery = Beneficiary::where('type', $type);

        //then if barangay admin only show what belongs in their barangay
        if ($this->currentUser->role === 'barangay_' . $type . '_admin') {
            $baseQuery->whereHas('address.street.barangay', function ($q) {
                $q->where('id', $this->currentUser->barangay_id);
            });
        }

        //cards
        $card_data = [
            'total' => (clone $baseQuery)->count(),
            'total_male' => (clone $baseQuery)->where('gender', 'Male')->count(),
            'total_female' => (clone $baseQuery)->where('gender', 'Female')->count()
        ];

        //barangay chart
        $barangayQuery = Barangay::leftJoin('streets', 'barangays.id', '=', 'streets.barangay_id')
            ->leftJoin('beneficiary_addresses', 'streets.id', '=', 'beneficiary_addresses.street_id')
            ->leftJoin('beneficiaries', function ($join) use ($type) {
                $join->on('beneficiary_addresses.id', '=', 'beneficiaries.beneficiary_address_id')
                    ->where('beneficiaries.type', $type);
            });

        if ($this->currentUser->role === 'barangay_' . $type . '_admin') {
            
            //limit the query to the current user barangay
            $barangayQuery->where('barangays.id', $this->currentUser->barangay_id);

            // count the data per street
            $barangayData = $barangayQuery
                ->select('streets.name', DB::raw('COUNT(beneficiaries.id) as total'))
                ->groupBy('streets.id', 'streets.name')
                ->orderBy('streets.name')
                ->get();

            $barangay_chart = [
                'labels' => $barangayData->pluck('name'), // street names
                'values' => $barangayData->pluck('total')
            ];
        }else{
            $barangayData = $barangayQuery
                ->select('barangays.name', DB::raw('COUNT(beneficiaries.id) as total'))
                ->groupBy('barangays.name')
                ->orderBy('barangays.name')
                ->get();

            $barangay_chart = [
                'labels' => $barangayData->pluck('name'),
                'values' => $barangayData->pluck('total')
            ];
        }

        //registration chart in the last 2 months
        $twoMonthsAgo = Carbon::now()->subMonths(1)->startOfMonth();

        $registrationData = (clone $baseQuery)
            ->where('created_at', '>=', $twoMonthsAgo)
            ->selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->get();

        $registration_chart = [
            'labels' => $registrationData->pluck('month'),
            'values' => $registrationData->pluck('total')
        ];

        //recent activities
        $recent_activities = (clone $baseQuery)
            ->with(['creator', 'updater'])
            ->latest()
            ->take(5)
            ->get();

        return compact(
            'card_data',
            'barangay_chart',
            'registration_chart',
            'recent_activities'
        );
    }


    public function pwdAdminIndex(){
        
        $data = $this->buildDashboardData('pwd');

        return view('dashboard/pwd_admin', ['data' => $data, 'current_user' => $this->currentUser]);
    }

    public function seniorAdminIndex()
    {
        
        $data = $this->buildDashboardData('senior');

        return view('dashboard/senior_admin', ['data' => $data, 'current_user' => $this->currentUser]);
    }
    
    // public function seniorAdminIndex()
    // {
    //     //filter first to just senior type data
    //     $baseQuery = Beneficiary::where('type', 'senior');

    //     //then if barangay senior admin only show what belongs in their barangay
    //     if ($this->currentUser->role === 'barangay_senior_admin') {
    //         $baseQuery->whereHas('address.street.barangay', function ($q) {
    //             $q->where('id', $this->currentUser->barangay_id);
    //         });
    //     }


    //     //card of total senior
    //     $card_data = [
    //         'total' => (clone $baseQuery)->count(),
    //         'total_male' => (clone $baseQuery)->where('gender', 'Male')->count(),
    //         'total_female' => (clone $baseQuery)->where('gender', 'Female')->count()
    //     ];
    //     // $total_senior = (clone $baseQuery)->count();
    //     // $total_male = (clone $baseQuery)->where('gender', 'Male')->count();
    //     // $total_female = (clone $baseQuery)->where('gender', 'Female')->count();
        
    //     //barangay chart
    //     $barangayQuery = Barangay::leftJoin('streets', 'barangays.id', '=', 'streets.barangay_id')
    //         ->leftJoin('beneficiary_addresses', 'streets.id', '=', 'beneficiary_addresses.street_id')
    //         ->leftJoin('beneficiaries', 'beneficiary_addresses.id', '=', 'beneficiaries.beneficiary_address_id')
    //         ->where('beneficiaries.type', 'senior');

    //     if ($this->currentUser->role === 'barangay_senior_admin') {
    //         $barangayQuery->where('barangays.id', $this->currentUser->barangay_id);
    //     }

    //     $barangayData = $barangayQuery
    //         ->select('barangays.name', DB::raw('COUNT(beneficiaries.id) as total'))
    //         ->groupBy('barangays.name')
    //         ->orderBy('barangays.name')
    //         ->get();

    //     $barangay_chart = [
    //         'labels' => $barangayData->pluck('name'),
    //         'values' => $barangayData->pluck('total')
    //     ];

    //     //registration chart in the last 2 months
    //     $twoMonthsAgo = Carbon::now()->subMonths(1)->startOfMonth();

    //     $registrationData = (clone $baseQuery)
    //         ->where('created_at', '>=', $twoMonthsAgo)
    //         ->selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(*) as total')
    //         ->groupBy('month')
    //         ->orderByRaw('MIN(created_at)')
    //         ->get();

    //     $registration_chart = [
    //         'labels' => $registrationData->pluck('month'),
    //         'values' => $registrationData->pluck('total')
    //     ];

    //     //recent activities
    //     $recent_activities = (clone $baseQuery)
    //         ->with(['creator', 'updater'])
    //         ->latest()
    //         ->take(5)
    //         ->get();

        
    //     return view('dashboard/senior_admin', [
    //         'card_data' => $card_data,
    //         'barangay_chart' => $barangay_chart,
    //         'registration_chart' => $registration_chart,
    //         'recent_activities' => $recent_activities
    //     ]);
    // }

    public function superAdminIndex(){

        $total_senior = SeniorDetail::count();
        $total_pwd = PwdDetail::count();
        $total_beneficiaries = $total_senior + $total_pwd;

        $data = Barangay::leftJoin('streets', 'barangays.id', '=', 'streets.barangay_id')
            ->leftJoin('beneficiary_addresses', 'streets.id', '=', 'beneficiary_addresses.street_id')
            ->leftJoin('beneficiaries', 'beneficiary_addresses.id', '=', 'beneficiaries.beneficiary_address_id')
            ->select(
                'barangays.name',
                DB::raw("COUNT(CASE WHEN beneficiaries.type = 'senior' THEN 1 END) as seniors_count"),
                DB::raw("COUNT(CASE WHEN beneficiaries.type = 'pwd' THEN 1 END) as pwd_count")
            )
            ->groupBy('barangays.name')
            ->orderBy('barangays.name')
            ->get();

        if($data){
            $barangay_chart = [
                'labels' => $data->pluck('name'),
                'seniors' => $data->pluck('seniors_count'),
                'pwd' => $data->pluck('pwd_count')

            ];
        }

        $twoMonthsAgo = Carbon::now()->subMonths(1)->startOfMonth();

        $registrationData = Beneficiary::selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(*) as total')
            ->where('created_at', '>=', $twoMonthsAgo)
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->get();

        // dd($registrationData);

        if($registrationData){
            $registration_chart = [
                'labels' => $registrationData->pluck('month'),
                'values' => $registrationData->pluck('total')
            ];
        }

        $recent_activities = Beneficiary::with(['creator', 'updater'])
            ->latest()
            ->take(5)
            ->get();
 
        

        return view('dashboard/super_admin', [
            'card_data' => [
                'total_senior' => $total_senior,
                'total_pwd'  => $total_pwd,
                'total_beneficiaries' => $total_beneficiaries
            ],
            'barangay_chart' => $barangay_chart,
            'registration_chart' => $registration_chart,
            'recent_activities' => $recent_activities,
            'current_user' => $this->currentUser
        ]);
    }


}
