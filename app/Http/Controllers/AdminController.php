<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Leave;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    }
    public function thmlogin()
    {
        return view('Dashboard.pages.samples.login');
    }
    public function thmreg()
    {
        return view('Dashboard.pages.samples.register');
    }
         
    public function viewModule($module, $id, $notification_id)
    {
        $notification = auth()->user()->notifications()->findOrFail($notification_id);


        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $routes = [
            'task' => fn($notification) => route('viewtask', ['id' => $notification->post_id]),
            'leave' => fn() => auth()->user()->hasRole('Admin') ? route('manageadminleave') : route('manageleave'),
            'faq' => fn() => route('displayfaq'),
        ];

        if (isset($routes[$module])) {
            return redirect()->to($routes[$module]($notification ?? null));
        }

        abort(404);
    }
}
