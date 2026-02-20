<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //


    public function adminIndex(){

        return view('dashboard/admin');
    }

    public function superAdminIndex(){

        return view('dashboard/super_admin');
    }


}
