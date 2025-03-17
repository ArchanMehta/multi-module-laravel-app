<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqContorller extends Controller
{


    public function displayfaq(){
        $faqs = Faq::all();
        return view("Dashboard.pages.forms.displayfaq",compact("faqs"));
    }
   

    public function editfaq(Request $request, String $id)
    {
        $faq = Faq::find($id);
        
        session()->flash('success', 'faq updated successfully!');
        return view("Dashboard.pages.forms.updatefaq", compact("faq"));
    }

    public function addfaqdata(Request $request)
    {
        $faq = Faq::create([
            'question' => $request->faqquestion,
            'description' => $request->faqdescription,

        ]);


        foreach (User::all() as $user) {
            NotificationService::createNotification(
                auth()->id(),
                $user->id,
                'faq',
                'New FAQ Added',
                "FAQ title: {$faq->question}",
                "FAQ Details: {$faq->description}",
                $faq->id,
            );
        }

        session()->flash('success', 'New faq has been added successfully!');
        
        return redirect()->route("managefaq");
    }
    //
    public function index(Request $request)
    {
        

        if ($request->ajax()) {
            $faqs = Faq::query();
            
            
            return DataTables::eloquent($faqs)
            
            
            ->addIndexColumn()
            ->addColumn('created_at', function ($faqs) {
                return Carbon::parse($faqs->created_at)->format('Y-m-d');
            })
            ->addColumn('action', function ($faqs) {
                return '<button data-id="' . $faqs->id . '" class="btn btn-success btn-sm edit-faq" style="background-color: #374151; color: white; padding: 5px 10px; border-radius: 5px; font-size: 14px; border: none; cursor: pointer; transition: background-color 0.3s;">
                <img src="' . asset('dashboard/images/edit_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" >
                </button>
    
                <button style="border-radius: 5px; " data-id="' . $faqs->id . '" class="btn btn-danger btn-sm delete-faq"><img src="' . asset('dashboard/images/delete_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" ></button> 
                ';
            })
            
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('Dashboard.pages.forms.addfaq');
    }
    
    
    
    
    public function destroy($id)
    {
        
        
        $faq = faq::findOrFail($id);
        if ($faq) {
            
            $faq->delete();
            return response()->json(['status' => 'success', 'message' => 'faq deleted successfully']);
        }
        return response()->json(['status' => 'failed', 'message' => 'Unable to delete faq']);
    }
    

    public function update(Request $request)
    {
        try {
            $faq = faq::findOrFail($request->id);
            if ($faq) {
                $faq->question = $request->faqquestion;
                $faq->description = $request->faqdescription;
                
                $faq->save();
                session()->flash('success', 'Faq has been updated successfully!');
                
                return redirect()->route("managefaq");
            } else {
                return response()->json(['status' => 'error', 'message' => 'Unable to Find faq!!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to Update faq - ' . $e->getMessage()]);
        }
    }
}
