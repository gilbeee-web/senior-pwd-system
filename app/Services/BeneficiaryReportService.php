<?php

namespace App\Services;

use App\Models\PwdDetail;
use App\Models\SeniorDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BeneficiaryReportService{

    
    public function getPwdQuery($request, $user)
    {

        //join all the tables needed 
        $query = PwdDetail::query()
            ->join('beneficiaries', 'beneficiaries.id', '=', 'pwd_details.beneficiary_id')
            ->leftJoin('beneficiary_addresses', 'beneficiary_addresses.id', '=', 'beneficiaries.beneficiary_address_id')
            ->leftJoin('streets', 'streets.id', '=', 'beneficiary_addresses.street_id');

        //Role filter (if barangay admin just data within their barangay)
        if ($user->role === 'barangay_pwd_admin') {
            $query->where('streets.barangay_id', $user->barangay_id);
        }

        // Search
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('pwd_details.pwd_id_number', 'like', "%{$search}%")
                ->orWhere('beneficiaries.first_name', 'like', "%{$search}%")
                ->orWhere('beneficiaries.middle_name', 'like', "%{$search}%")
                ->orWhere('beneficiaries.last_name', 'like', "%{$search}%");
            });
        }

        // filters using join earlier
        if ($request->disability_type) {
            $query->where('pwd_details.disability_type', $request->disability_type);
        }

        if ($request->educational_attainment) {
            $query->where('pwd_details.educational_attainment', $request->educational_attainment);
        }

        if ($request->barangay) {
            $query->where('streets.barangay_id', $request->barangay);
        }

        if ($request->gender) {
            $query->where('beneficiaries.gender', $request->gender);
        }

        if ($request->civil_status) {
            $query->where('beneficiaries.civil_status', $request->civil_status);
        }

        if ($request->employment_status) {
            $query->where('beneficiaries.employment_status', $request->employment_status);
        }

        // age filter
        if ($request->min_age || $request->max_age) {
            $min = $request->min_age ?? 0;
            $max = $request->max_age ?? 59;

            $minDate = now()->subYears($max)->startOfDay();
            $maxDate = now()->subYears($min)->endOfDay();

            $query->whereBetween('beneficiaries.birthdate', [$minDate, $maxDate]);
        }

        if ($request->eligibility_status) {

            if ($request->eligibility_status === 'eligible') {
                $query->where('beneficiaries.life_status', 'alive')
                    ->where('beneficiaries.residence_status', 'active')
                    ->where('pwd_details.is_middleclass', 0);
            }

            if ($request->eligibility_status === 'not_eligible') {
                $query->where(function ($q) {
                    $q->where('beneficiaries.life_status', 'deceased')
                    ->orWhere('beneficiaries.residence_status', 'transferred')
                    ->orWhere('pwd_details.is_middleclass', 1);
                });
            }
        }


        // order by recently added
        $query->orderBy('beneficiaries.created_at', 'desc');

        $query->select('pwd_details.*');

        // load all the needed data for display
        $query->with([
            'beneficiary:id,first_name,last_name,gender,civil_status,employment_status,birthdate,beneficiary_address_id,life_status,residence_status',

            'beneficiary.address:id,street_id,house_num,municipality,province,zip_code',

            'beneficiary.address.street:id,name,barangay_id',

            'beneficiary.address.street.barangay:id,name',
        ]);

        return $query;
    }


    // 
    

    public function getSeniorQuery($request, $user)
    {
        $query = SeniorDetail::query()
            ->join('beneficiaries', 'beneficiaries.id', '=', 'senior_details.beneficiary_id')
            ->join('beneficiary_addresses', 'beneficiary_addresses.id', '=', 'beneficiaries.beneficiary_address_id')
            ->join('streets', 'streets.id', '=', 'beneficiary_addresses.street_id')
            ->select('senior_details.*')
            ->distinct();

        // if the role is barangay admin show data only belong in their baranggay
        if ($user->role === 'barangay_senior_admin') {
            $query->where('streets.barangay_id', $user->barangay_id);
        }

        // filter by barangay
        if ($request->barangay) {
            $query->where('streets.barangay_id', $request->barangay);
        }

        // Search
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('senior_details.osca_id_number', 'like', "%{$search}%")
                ->orWhere('beneficiaries.first_name', 'like', "%{$search}%")
                ->orWhere('beneficiaries.middle_name', 'like', "%{$search}%")
                ->orWhere('beneficiaries.last_name', 'like', "%{$search}%");
            });
        }

        // filters based on the join 
        if ($request->gender) {
            $query->where('beneficiaries.gender', $request->gender);
        }

        if ($request->civil_status) {
            $query->where('beneficiaries.civil_status', $request->civil_status);
        }

        if ($request->employment_status) {
            $query->where('beneficiaries.employment_status', $request->employment_status);
        }

        // filter by age range 
        if ($request->senior_type) {

            if ($request->senior_type === 'Senior') {
                $query->whereBetween('beneficiaries.birthdate', [
                    now()->subYears(79)->startOfDay(),
                    now()->subYears(60)->endOfDay()
                ]);
            } elseif ($request->senior_type === 'Octogenarian') {
                $query->whereBetween('beneficiaries.birthdate', [
                    now()->subYears(89)->startOfDay(),
                    now()->subYears(80)->endOfDay()
                ]);
            } elseif ($request->senior_type === 'Nonagenarian') {
                $query->whereBetween('beneficiaries.birthdate', [
                    now()->subYears(99)->startOfDay(),
                    now()->subYears(90)->endOfDay()
                ]);
            } elseif ($request->senior_type === 'Centenarian') {
                $query->where('beneficiaries.birthdate', '<=', now()->subYears(100));
            }
        }

        // if the beneficiary birthday
        if ($request->isBday) {
            $query->whereMonth('beneficiaries.birthdate', now()->month)
                ->whereDay('beneficiaries.birthdate', now()->day);
        }

        if ($request->status) {

            if ($request->status === 'active') {
                $query->where('beneficiaries.life_status', 'alive')
                    ->where('beneficiaries.residence_status', 'active');
            }

            if ($request->status === 'transferred') {
                $query->where('beneficiaries.residence_status', 'inactive');
            }

            if ($request->status === 'deceased') {
                $query->where('beneficiaries.life_status', 'deceased');
            }
        }

        // sorting by recently added
        $query->orderBy('beneficiaries.created_at', 'desc');

        // load for display
        $query->with([
            'beneficiary:id,first_name,last_name,gender,civil_status,employment_status,birthdate,beneficiary_address_id,life_status,residence_status',

            'beneficiary.address:id,street_id,house_num,municipality,province,zip_code',

            'beneficiary.address.street:id,name,barangay_id',

            'beneficiary.address.street.barangay:id,name',
        ]);

        return $query;
    }


    // public function getSeniorQuery($request, $user)
    // {
    //     $query = SeniorDetail::with('beneficiary.address');

    //     if (in_array($user->role, ['barangay_senior_admin'])) {
    //         $query->whereHas('beneficiary.address.street', function ($q) use ($user) {
    //             $q->where('barangay_id', $user->barangay_id);
    //         });
    //     }

    //     // filter by BARANGAY
    //     if ($request->barangay) {
    //         $query->whereHas('beneficiary.address.street', function ($q) use ($request) {
    //             $q->where('barangay_id', $request->barangay);
    //         });
    //     }



    //     if ($request->search) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('osca_id_number', 'like', "%{$request->search}%")
    //               ->orWhereHas('beneficiary', function ($q2) use ($request) {
    //                   $q2->where('first_name', 'like', "%{$request->search}%")
    //                      ->orWhere('last_name', 'like', "%{$request->search}%");
    //               });
    //         });
    //     }

    //     //filter by gender
    //     if ($request->gender) {
    //         $query->whereHas('beneficiary', function ($q) use ($request) {
    //             $q->where('gender', $request->gender);
    //         });
    //     }

    //     //filter by civil status
    //     if ($request->civil_status) {
    //         $query->whereHas('beneficiary', function ($q) use ($request) {
    //             $q->where('civil_status', $request->civil_status);
    //         });
    //     }

    //     //filter by civil status
    //     if ($request->employment_status) {
    //         $query->whereHas('beneficiary', function ($q) use ($request) {
    //             $q->where('employment_status', $request->employment_status);
    //         });
    //     }

    //     if ($request->senior_type) {
    //         $today = now()->format('Y-m-d');
    //         $ageExpr = "TIMESTAMPDIFF(YEAR, birthdate, '$today')";

    //         $query->whereHas('beneficiary', function ($q) use ($request, $ageExpr) {
    //             if ($request->senior_type === 'Senior') {
    //                 $q->whereBetween(DB::raw($ageExpr), [60, 79]);
    //             } elseif ($request->senior_type === 'Octogenarian') {
    //                 $q->whereBetween(DB::raw($ageExpr), [80, 89]);
    //             } elseif ($request->senior_type === 'Nonagenarian') {
    //                 $q->whereBetween(DB::raw($ageExpr), [90, 99]);
    //             } elseif ($request->senior_type === 'Centenarian') {
    //                 $q->where(DB::raw($ageExpr), '>=', 100);
    //             }
    //         });
    //     }

    //     if ($request->isBday) {
    //         $todayMonth = now()->month;
    //         $todayDay = now()->day;

    //         $query->whereHas('beneficiary', function ($q) use ($todayMonth, $todayDay) {
    //             $q->whereMonth('birthdate', $todayMonth)
    //             ->whereDay('birthdate', $todayDay);
    //         });
    //     }

    //     //make it alphabetical order based on last name
    //     $query->join('beneficiaries', 'beneficiaries.id', '=', 'senior_details.beneficiary_id')
    //       ->orderBy('beneficiaries.created_at', 'desc')
    //       ->select('senior_details.*');

    //     return $query;
    // }



    // public function getPwdQuery($request, $user){

    //     $query = PwdDetail::with('beneficiary.address');

    //     if (in_array($user->role, ['barangay_pwd_admin'])) {
    //         $query->whereHas('beneficiary.address.street', function ($q) use ($user) {
    //             $q->where('barangay_id', $user->barangay_id);
    //         });
    //     }

    //     if ($request->search) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('pwd_id_number', 'like', "%{$request->search}%")
    //               ->orWhereHas('beneficiary', function ($q2) use ($request) {
    //                   $q2->where('first_name', 'like', "%{$request->search}%")
    //                      ->orWhere('last_name', 'like', "%{$request->search}%");
    //               });
    //         });
    //     }

    //     // filter by DISABILITY TYPE
    //     if ($request->disability_type) {
    //         $query->where('disability_type', $request->disability_type);
    //     }

    //     // filter by Educational Attainment
    //     if ($request->educational_attainment) {
    //         $query->where('educational_attainment', $request->educational_attainment);
    //     }

    //     // filter by BARANGAY
    //     if ($request->barangay) {
    //         $query->whereHas('beneficiary.address.street', function ($q) use ($request) {
    //             $q->where('barangay_id', $request->barangay);
    //         });
    //     }

    //     //filter by gender
    //     if ($request->gender) {
    //         $query->whereHas('beneficiary', function ($q) use ($request) {
    //             $q->where('gender', $request->gender);
    //         });
    //     }

    //     //filter by civil status
    //     if ($request->civil_status) {
    //         $query->whereHas('beneficiary', function ($q) use ($request) {
    //             $q->where('civil_status', $request->civil_status);
    //         });
    //     }

    //     //filter by civil status
    //     if ($request->employment_status) {
    //         $query->whereHas('beneficiary', function ($q) use ($request) {
    //             $q->where('employment_status', $request->employment_status);
    //         });
    //     }

    //     if ($request->min_age || $request->max_age) {

    //         //get the request
    //         $min = $request->min_age ?? 0;
    //         $max = $request->max_age ?? 59;

    //         // Convert age to birthdate range
    //         $minDate = Carbon::now()->subYears($max)->startOfDay(); // oldest
    //         $maxDate = Carbon::now()->subYears($min)->endOfDay();   // youngest

    //         //then get that data using whereBetween
    //         $query->whereHas('beneficiary', function ($q) use ($minDate, $maxDate) {
    //             $q->whereBetween('birthdate', [$minDate, $maxDate]);
    //         });
    //     }

    //     $query->join('beneficiaries', 'beneficiaries.id', '=', 'pwd_details.beneficiary_id')
    //         ->orderBy('beneficiaries.created_at', 'desc')
    //         ->select('pwd_details.*');



    //     return $query;
    // }




}

