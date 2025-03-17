<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserData;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{


    public function getChatUsers()
    {
        $users = User::all(['id', 'name']);
        return response()->json($users);
    }


    public function allroles()
    {
        // Retrieve all roles from the UserData model
        $allroles = Role::all(); // Ensure 'UserData' is the correct model for fetching roles

        // Return the view and pass the 'allroles' variable
        return view("Dashboard.pages.forms.adduser", compact("allroles"));
    }


    public function manageuserroles()
    {
        // Retrieve all roles from the UserData model
        $allroles = Role::all(); // Ensure 'UserData' is the correct model for fetching roles

        // Return the view and pass the 'allroles' variable
        return view("Dashboard.pages.forms.manageuser", compact("allroles"));
    }




    public function edituser(Request $request, String $id)
    {
        $allroles = Role::all();
        $user = User::find($id);
        return view("Dashboard.pages.forms.updateuser", compact(["user", "allroles"]));
    }



    public function adduserdata(Request $request)
    {

        $user = User::create([
            'name' => $request->username,
            'email' => $request->useremail,
            'phone' => $request->userphoneno,
            'age' => $request->userage,
            'city' => $request->usercity,
            'role' => $request->userrole,


        ]);
        session()->flash('success', 'User has been added successfully!');

        return redirect()->route("manageuser");
    }
    //
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $users = User::query();

            // Filter users by role if provided
            if ($request->has('role') && $request->role != '') {
                $users->where('role', $request->role); // Filter by role name (string)
            }


            return DataTables::eloquent($users)


                ->addIndexColumn()
                ->addColumn('created_at', function ($user) {
                    return Carbon::parse($user->created_at)->format('Y-m-d');
                })
                ->addColumn('action', function ($user) {
                    return '
                        <button data-id="' . $user->id . '" class="btn btn-success btn-sm edit-user" style="background-color: #374151; color: white; padding: 5px 10px; border-radius: 5px; font-size: 14px; border: none; cursor: pointer; transition: background-color 0.3s;">
                            <img src="' . asset('dashboard/images/edit_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" >
                        </button>
                        <button style="border-radius: 5px;" data-id="' . $user->id . '" class="btn btn-danger btn-sm delete-user">
                            <img src="' . asset('dashboard/images/delete_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" >
                        </button>';
                })


                ->rawColumns(['action'])
                ->make(true);
        }

        // $roles = User::select('role')->distinct()->get();

        return view('Dashboard.pages.forms.adduser');

        // return view('layouts.edituser-form', compact('roles'));
    }




    public function destroy($id)
    {


        $user = User::findOrFail($id);
        if ($user) {

            $user->delete();



            return response()->json(['status' => 'success', 'message' => 'User deleted successfully']);
        }
        return response()->json(['status' => 'failed', 'message' => 'Unable to delete user']);
    }


    public function update(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            if ($user) {
                $user->name = $request->username;
                $user->email = $request->useremail;
                $user->phone = $request->userphoneno;
                $user->age = $request->userage;
                $user->city = $request->usercity;
                $user->role = $request->userrole;
                $user->save();
                return redirect()->route("manageuser")->with(['status' => 'success', 'message' => 'User Updated Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Unable to find User!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to update User - ' . $e->getMessage()]);
        }
    }
}
