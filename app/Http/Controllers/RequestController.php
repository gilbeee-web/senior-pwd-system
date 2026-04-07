<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePwdRequest;
use App\Http\Requests\UpdateSeniorRequest;
use App\Models\ActionRequest;
use App\Models\PwdDetail;
use App\Models\SeniorDetail;
use App\Services\RequestApprovalService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    //

   

    public function approve($id, RequestApprovalService $service){

        $request = ActionRequest::find($id);

        $current_user = Auth::user();

        $service->approve($request, $current_user->id);

        return back()->with('success', 'Request approved successfully.');
    }


    public function reject($id, RequestApprovalService $service)
    {
        $current_user = Auth::user();
        $request = Request::findOrFail($id);

        $service->reject($request, $current_user->id);

        return back()->with('success', 'Request rejected.');
    }


    


    


    


    



}
