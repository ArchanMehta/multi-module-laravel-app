<?php

namespace App\Http\Controllers;

use App\Models\Cms;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CMSController extends Controller
{
    
    public function displaycms(){
        $cmss = Cms::all();
        return view("Dashboard.pages.forms.displaycms",compact("cmss"));
    }
   

    public function editcms(Request $request, String $id)
    {
        $cms = Cms::find($id);
        
        session()->flash('success', 'cms updated successfully!');
        return view("Dashboard.pages.forms.updatecms", compact("cms"));
    }

    public function addcmsdata(Request $request)
    {
        Cms::create([
            'cmstitle' => $request->cmsquestion,
            'cmsdescription' => $request->cmsdescription,

        ]);

        session()->flash('success', 'New cms has been added successfully!');
        
        return redirect()->route("managecms");
    }
    //
    public function index(Request $request)
    {
        

        if ($request->ajax()) {
            $cmss = Cms::query();
            
            
            return DataTables::eloquent($cmss)
            
            
            ->addIndexColumn()
            
            ->addColumn('created_at', function ($cmss) {
                return Carbon::parse($cmss->created_at)->format('Y-m-d');
            })
            ->addColumn('action', function ($cmss) {
                return '<button data-id="' . $cmss->id . '" class="btn btn-success btn-sm edit-cms" style="background-color: #374151; color: white; padding: 5px 10px; border-radius: 5px; font-size: 14px; border: none; cursor: pointer; transition: background-color 0.3s;">
                <img src="' . asset('dashboard/images/edit_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" >
                </button>
    
                <button style="border-radius: 5px; " data-id="' . $cmss->id . '" class="btn btn-danger btn-sm delete-cms"><img src="' . asset('dashboard/images/delete_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" ></button> 
                ';
            })
            
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('Dashboard.pages.forms.addcms');
    }
    
    
    
    
    public function destroy($id)
    {
        
        
        $cms = Cms::findOrFail($id);
        if ($cms) {
            
            $cms->delete();
            return response()->json(['status' => 'success', 'message' => 'cms deleted successfully']);
        }
        return response()->json(['status' => 'failed', 'message' => 'Unable to delete cms']);


       
    }
    

    public function update(Request $request)
    {
        try {
            $cms = Cms::findOrFail($request->id);
            if ($cms) {
                $cms->cmsquestion = $request->cmsquestion;
                $cms->cmsdescription = $request->cmsdescription;
                
                $cms->save();
                session()->flash('success', 'cms has been updated successfully!');
                
                return redirect()->route("managecms");
            } else {
                return response()->json(['status' => 'error', 'message' => 'Unable to Find cms!!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to Update cms - ' . $e->getMessage()]);
        }
    }
}
