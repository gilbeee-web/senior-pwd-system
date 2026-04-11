<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //


    public function pwdAdminIndex(){

        return view('dashboard/pwd_admin');
    }

    public function seniorAdminIndex(){
        return view('dashboard/senior_admin');
    }

    public function superAdminIndex(){

        return view('dashboard/super_admin');
    }


}
