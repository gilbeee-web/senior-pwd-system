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

    protected $currentUserRole;

    public function __construct()
    {
        $current_user = Auth::user();

        $this->currentUserRole = $current_user->role;
    }

    public function index(Request $request){

        $query = ActionRequest::with(['requester', 'model.beneficiary']);
        $tab_status = $request->status ?? 'pending';

        
        $query->where('status', $tab_status);
        

        //filter by type of request ('Archive' , 'Update')
        if($request->type){
            $query->where('type', $request->type);
        }

        //filter if the role is super_admin 
        if ($this->currentUserRole !== 'super_admin') {

            if ($this->currentUserRole === 'pwd_admin') {
                $query->where('model_type', 'App\Models\PwdDetail');
            } elseif ($this->currentUserRole === 'senior_admin') {
                $query->where('model_type', 'App\Models\SeniorDetail');
            }

        } else {
            // Super admin can filter manually by model_type if provided
            if ($request->model_type) {
                $query->where('model_type', $request->model_type);
            }
        }


        // Filter by date range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ]);
        } elseif ($request->start_date) {
            $query->where('created_at', '>=', Carbon::parse($request->start_date)->startOfDay());
        } elseif ($request->end_date) {
            $query->where('created_at', '<=', Carbon::parse($request->end_date)->endOfDay());
        }

        $requests = $query->latest()->paginate(10);
        
        // dd($requests);
    
        return view('requests/index', ['requests' => $requests, 'tab_status' => $tab_status]);
    }
   

    public function approve($id, RequestApprovalService $service){

        $request = ActionRequest::find($id);

        $current_user = Auth::user();

        $service->approve($request, $current_user->id);

        return response()->json([
            'success' => true,
            'message' => 'Approved successfully'
        ]);

        // return back()->with('success', 'Request approved successfully.');
    }


    public function reject($id, RequestApprovalService $service)
    {
        $current_user = Auth::user();
        $request = Request::findOrFail($id);

        $service->reject($request, $current_user->id);

        return back()->with('success', 'Request rejected.');
    }


    


    


    


    



}
