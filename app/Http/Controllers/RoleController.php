<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{


    public function editrole(Request $request, String $id)
    {
        $role = Role::find($id);
        
        session()->flash('success', 'Role updated successfully!');
        return view("Dashboard.pages.forms.updaterole", compact("role"));
    }

    public function addroledata(Request $request)
    {
        Role::create([
            'title' => $request->roletitle,
            'status' => $request->rolestatus,

        ]);

        session()->flash('success', 'New Role has been added successfully!');
        
        return redirect()->route("managerole");
    }
    //
    public function index(Request $request)
    {
        
        
        if ($request->ajax()) {
            $roles = Role::query();
            
            
            return DataTables::eloquent($roles)
            
            
            ->addIndexColumn()
            ->addColumn('created_at', function ($roles) {
                return Carbon::parse($roles->created_at)->format('Y-m-d');
            })
            ->addColumn('action', function ($roles) {
                return '<button data-id="' . $roles->id . '" class="btn btn-success btn-sm edit-role" style="background-color: #374151; color: white; padding: 5px 10px; border-radius: 5px; font-size: 14px; border: none; cursor: pointer; transition: background-color 0.3s;">
                <img src="' . asset('dashboard/images/edit_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" >
                </button>
                
                <button style="border-radius: 5px; " data-id="' . $roles->id . '" class="btn btn-danger btn-sm delete-role"><img src="' . asset('dashboard/images/delete_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" ></button> 
                ';
            })
            
            ->rawColumns(['action'])
                ->make(true);
            }
            
            return view('Dashboard.pages.forms.addrole');
        }
        
        
        
        
        public function destroy($id)
        {
            
            
            $role = Role::findOrFail($id);
            if ($role) {
                
                $role->delete();
                return response()->json(['status' => 'success', 'message' => 'Role deleted successfully']);
            }
            return response()->json(['status' => 'failed', 'message' => 'Unable to delete Role']);
        }
        

    public function update(Request $request)
    {
        try {
            $role = Role::findOrFail($request->id);
            if ($role) {
                $role->title = $request->roletitle;
                $role->status = $request->rolestatus;
                
                $role->save();
                session()->flash('success', 'Role has been updated successfully!');
                return redirect()->route("managerole");
            } else {
                return response()->json(['status' => 'error', 'message' => 'Unable to Find Role!!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to Update Role - ' . $e->getMessage()]);
        }
    }
}
