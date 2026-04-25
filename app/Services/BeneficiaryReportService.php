<?php

namespace App\Services;

use App\Models\PwdDetail;
use App\Models\SeniorDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BeneficiaryReportService{

    public function getPwdQuery($request, $user){

        $query = PwdDetail::with('beneficiary.address');

        if (in_array($user->role, ['barangay_pwd_admin'])) {
            $query->whereHas('beneficiary.address.street', function ($q) use ($user) {
                $q->where('barangay_id', $user->barangay_id);
            });
        }

        //show only what they created if not categorized by barangay
        // if (in_array($user->role, ['barangay_pwd_admin'])) {
        //     $query->whereHas('beneficiary.address.street', function ($q) use ($user) {
        //         $q->where('created_by', $user->id);
        //     });
        // }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pwd_id_number', 'like', "%{$request->search}%")
                  ->orWhereHas('beneficiary', function ($q2) use ($request) {
                      $q2->where('first_name', 'like', "%{$request->search}%")
                         ->orWhere('last_name', 'like', "%{$request->search}%");
                  });
            });
        }

        // filter by DISABILITY TYPE
        if ($request->disability_type) {
            $query->where('disability_type', $request->disability_type);
        }

        // filter by Educational Attainment
        if ($request->educational_attainment) {
            $query->where('educational_attainment', $request->educational_attainment);
        }

        // filter by BARANGAY
        if ($request->barangay) {
            $query->whereHas('beneficiary.address.street', function ($q) use ($request) {
                $q->where('barangay_id', $request->barangay);
            });
        }

        //filter by gender
        if ($request->gender) {
            $query->whereHas('beneficiary', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        //filter by civil status
        if ($request->civil_status) {
            $query->whereHas('beneficiary', function ($q) use ($request) {
                $q->where('civil_status', $request->civil_status);
            });
        }

        //filter by civil status
        if ($request->employment_status) {
            $query->whereHas('beneficiary', function ($q) use ($request) {
                $q->where('employment_status', $request->employment_status);
            });
        }

        if ($request->min_age || $request->max_age) {

            //get the request
            $min = $request->min_age ?? 0;
            $max = $request->max_age ?? 59;

            // Convert age to birthdate range
            $minDate = Carbon::now()->subYears($max)->startOfDay(); // oldest
            $maxDate = Carbon::now()->subYears($min)->endOfDay();   // youngest

            //then get that data using whereBetween
            $query->whereHas('beneficiary', function ($q) use ($minDate, $maxDate) {
                $q->whereBetween('birthdate', [$minDate, $maxDate]);
            });
        }

        $query->join('beneficiaries', 'beneficiaries.id', '=', 'pwd_details.beneficiary_id')
            ->orderBy('beneficiaries.created_at', 'desc')
            ->select('pwd_details.*');



        return $query;
    }


    public function getSeniorQuery($request, $user)
    {
        $query = SeniorDetail::with('beneficiary.address');

        if (in_array($user->role, ['barangay_senior_admin'])) {
            $query->whereHas('beneficiary.address.street', function ($q) use ($user) {
                $q->where('barangay_id', $user->barangay_id);
            });
        }

        // filter by BARANGAY
        if ($request->barangay) {
            $query->whereHas('beneficiary.address.street', function ($q) use ($request) {
                $q->where('barangay_id', $request->barangay);
            });
        }



        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('osca_id_number', 'like', "%{$request->search}%")
                  ->orWhereHas('beneficiary', function ($q2) use ($request) {
                      $q2->where('first_name', 'like', "%{$request->search}%")
                         ->orWhere('last_name', 'like', "%{$request->search}%");
                  });
            });
        }

        //filter by gender
        if ($request->gender) {
            $query->whereHas('beneficiary', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        //filter by civil status
        if ($request->civil_status) {
            $query->whereHas('beneficiary', function ($q) use ($request) {
                $q->where('civil_status', $request->civil_status);
            });
        }

        //filter by civil status
        if ($request->employment_status) {
            $query->whereHas('beneficiary', function ($q) use ($request) {
                $q->where('employment_status', $request->employment_status);
            });
        }

        if ($request->senior_type) {
            $today = now()->format('Y-m-d');
            $ageExpr = "TIMESTAMPDIFF(YEAR, birthdate, '$today')";

            $query->whereHas('beneficiary', function ($q) use ($request, $ageExpr) {
                if ($request->senior_type === 'Senior') {
                    $q->whereBetween(DB::raw($ageExpr), [60, 79]);
                } elseif ($request->senior_type === 'Octogenarian') {
                    $q->whereBetween(DB::raw($ageExpr), [80, 89]);
                } elseif ($request->senior_type === 'Nonagenarian') {
                    $q->whereBetween(DB::raw($ageExpr), [90, 99]);
                } elseif ($request->senior_type === 'Centenarian') {
                    $q->where(DB::raw($ageExpr), '>=', 100);
                }
            });
        }

        if ($request->isBday) {
            $todayMonth = now()->month;
            $todayDay = now()->day;

            $query->whereHas('beneficiary', function ($q) use ($todayMonth, $todayDay) {
                $q->whereMonth('birthdate', $todayMonth)
                ->whereDay('birthdate', $todayDay);
            });
        }

        //make it alphabetical order based on last name
        $query->join('beneficiaries', 'beneficiaries.id', '=', 'senior_details.beneficiary_id')
          ->orderBy('beneficiaries.created_at', 'desc')
          ->select('senior_details.*');

        return $query;
    }


}

