<?php

namespace App\Http\Controllers;

use App\Imports\ContactsImport;
use App\Models\Contact;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{

    public function uploadCsv(Request $request)
    {
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'csvFile' => 'required|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle the uploaded CSV file
        if ($request->hasFile('csvFile')) {
            $file = $request->file('csvFile');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));

            // Assuming the first row is the header
            $header = array_shift($data);

            // Map header to database fields
            $columns = ['name', 'email', 'phoneno', 'city', 'country'];

            if (count($header) !== count($columns)) {
                return redirect()->back()->with('error', 'CSV format is invalid.');
            }

            foreach ($data as $row) {
                $row = array_combine($columns, $row);

                // Validate and store each row
                Contact::create($row);
            }

            return redirect()->back()->with('success', 'CSV data uploaded and stored successfully!');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

      // Import contacts from Excel
      public function import(Request $request)
      {
          $request->validate([
              'csvFile' => 'required|file|mimes:xlsx,csv',
          ]);
  
          Excel::import(new ContactsImport, $request->file('csvFile'));
  
          return redirect()->route('managecontact')->with('success', 'Contacts Imported Successfully');
      }

    public function editcontact(Request $request, String $id)
    {
       
        $contact = Contact::find($id);
        return view("Dashboard.pages.forms.updatecontact", compact(["contact"]));
    }



    public function addcontactdata(Request $request)
    {

        $contact = Contact::create([
            'name' => $request->contactname,
            'email' => $request->contactemail,
            'phoneno' => $request->contactphoneno,
            'city' => $request->contactcity,
            'country' => $request->contactcountry,
                       
           
                      

        ]);
        session()->flash('success', 'contact has been added successfully!');

        return redirect()->route("managecontact");
    }
    //
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $contacts = contact::query();



            return DataTables::eloquent($contacts)


                ->addIndexColumn()
                ->addColumn('created_at', function ($contact) {
                    return Carbon::parse($contact->created_at)->format('Y-m-d');
                })
                ->addColumn('action', function ($contact) {
                    return '
                        <button data-id="' . $contact->id . '" class="btn btn-success btn-sm edit-contact" style="background-color: #374151; color: white; padding: 5px 10px; border-radius: 5px; font-size: 14px; border: none; cursor: pointer; transition: background-color 0.3s;">
                            <img src="' . asset('dashboard/images/edit_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" >
                        </button>
                        <button style="border-radius: 5px;" data-id="' . $contact->id . '" class="btn btn-danger btn-sm delete-contact">
                            <img src="' . asset('dashboard/images/delete_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" >
                        </button>';
                })


                ->rawColumns(['action'])
                ->make(true);
        }

        // $roles = contact::select('role')->distinct()->get();

        return view('Dashboard.pages.forms.addcontact');

        // return view('layouts.editcontact-form', compact('roles'));
    }


    public function destroy($id)
    {


        $contact = Contact::findOrFail($id);
        if ($contact) {

            $contact->delete();



            return response()->json(['status' => 'success', 'message' => 'contact deleted successfully']);
        }
        return response()->json(['status' => 'failed', 'message' => 'Unable to delete contact']);
    }


    public function update(Request $request)
    {
        try {
            $contact = Contact::findOrFail($request->id);
            if ($contact) {
                $contact->name = $request->contactname;
                $contact->email = $request->contactemail;
                $contact->phoneno = $request->contactphoneno;    
                $contact->city = $request->contactcity;
                $contact->country = $request->contactcountry;
                $contact->save();
                return redirect()->route("managecontact")->with(['status' => 'success', 'message' => 'contact Updated Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Unable to find contact!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to update contact - ' . $e->getMessage()]);
        }
    }
}
