<?php

namespace App\Http\Controllers;

use App\Models\AuthorizeEmployee;
use Exception;
use Illuminate\Http\Request;

class AuthorizeEmployeeController extends Controller
{
    //

    public function index(){

        $all_employee = AuthorizeEmployee::orderBy('created_at', 'desc')->get();

        return view('authorize_employee/index', [
            'employees' => $all_employee, 
            'employee' => null
        ]);
    }

    public function store(Request $request){

        // dd($request->all());
        try{
            $validated = $request->validate([
                'full_name' => 'string|required',
                'position' => 'string|required',
                'role' => 'string|required'
            ]);

            // dd($validated);

            // deactivate old active with same role
            AuthorizeEmployee::where('role', $validated['role'])
                ->update(['is_active' => false]);

            $validated['is_active'] = true; // default true

            AuthorizeEmployee::create($validated);

            return redirect()->back()->with('success', "Authorize Employee added successfully!");
        }catch(Exception $e){
            return back()->withInput()->with('error', 'Something went wrong. Please try again');
        }
        
    }

    public function edit($id){

        $authorize_employee = AuthorizeEmployee::findOrFail($id); // find the employee to edit
        $all_employee = AuthorizeEmployee::all(); //return again all employee for index

        return view('authorize_employee/index', [
            'employees' => $all_employee, 
            'employee' => $authorize_employee
        ]);
    }

    public function update(Request $request, $id){
        $employee = AuthorizeEmployee::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string',
            'position' => 'required|string',
            'role' => 'required|string',
        ]);

        // deactivate same role
        AuthorizeEmployee::where('role', $validated['role'])
            ->where('id', '!=', $id)
            ->update(['is_active' => false]);

        $employee->update($validated);

        return redirect()->route('settings.index')->with('success', 'Updated!');
    }

    public function destroy($id){

        $employee = AuthorizeEmployee::findOrFail($id);

        $employee->delete();

        return redirect()->back()->with('success', "Authorize Employee deleted successfully!");

    }


    public function updateStatus($id)
    {
        $employee = AuthorizeEmployee::findOrFail($id);

        
        // deactivate old active with same role
        if(!$employee->is_active){
            AuthorizeEmployee::where('role', $employee->role)
                ->where('id', '!=', $employee->id)
                ->update(['is_active' => false]);
        }

        $employee->update([
            'is_active' => !$employee->is_active
        ]);

        $status = $employee->is_active ? 'Activated' : 'Deactivated';

        return redirect()->back()->with('success', "Authorize Employee {$status} successfully!");
    }




}
