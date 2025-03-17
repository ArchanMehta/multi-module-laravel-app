<?php

// Import necessary controllers for handling routes
use App\Http\Controllers\AdminController;

use App\Http\Controllers\ClockInOutController;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqContorller;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoginCheck;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

//! Public Routes
Route::get('/thmreg', [AdminController::class, 'thmreg'])->name('thmreg')->middleware(LoginCheck::class); // Registration page route
Route::get('/', [AdminController::class, 'thmlogin'])->name('thmlogin')->middleware(LoginCheck::class); // Login page route

//! Authenticated and Verified User Routes
Route::middleware(['auth', 'verified'])->group(function () {


    Route::get('view/{module}/{id}/{notification_id}', [AdminController::class, 'viewModule'])->name('viewmodule');



    Route::get('/admin', [AdminController::class, 'index'])->name('index'); // Admin dashboard route
    Route::get("/displayfaq", [FaqContorller::class, "displayfaq"])->name("displayfaq"); // Display all FAQs
    //! Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit profile route
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile route
    Route::view('/updatepassword', 'profile.partials.update-password-form')->name('updatepassword'); // View to update password



    //!Admin Accessible Routes
    Route::middleware(["role:Admin"])->group(function () {



        //! User Management Routes 
        Route::controller(UserController::class)->group(function () {


            Route::get('viewuserdata', 'manageuserroles')->name('manageuser'); // View user roles and permissions
            Route::get("/adduser/{id}/edit", "edituser")->name('edit_user'); // Edit user route
            Route::post("/updateuser/{id}", "update")->name('update_user'); // Update user route
            Route::get('users', 'index')->name('users.index'); // List all users
            Route::get('users/edit/{id}', 'edit')->name('users.edit'); // Edit user data
            Route::delete('users/delete/{id}', 'destroy')->name('users.destroy'); // Delete user route
        });




        //! Role Management Routes    
        Route::get("/addroleview", function () {
            return view("Dashboard.pages.forms.addrole"); // View to add a new role
        })->name('add_role_view');
        Route::view('viewroledata', 'Dashboard.pages.forms.managerole')->name('managerole'); // View to manage roles
        Route::controller(RoleController::class)->group(function () {

            Route::get("/addrole/{id}/edit", "editrole")->name('edit_role'); // Edit role route
            Route::post("/updaterole/{id}", "update")->name('update_role'); // Update role route
            Route::post("/addroledata", "addroledata")->name('add_role_data'); // Add new role route
            Route::get('roles', 'index')->name('roles.index'); // List all roles
            Route::get('roles/edit/{id}', 'edit')->name('roles.edit'); // Edit role data
            Route::delete('roles/delete/{id}', 'destroy')->name('roles.destroy'); // Delete role route
        });



        //! Contact Management Routes    
        Route::get("/addcontactview", function () {
            return view("Dashboard.pages.forms.addcontact"); // View to add a new contact
        })->name('add_contact_view');
        Route::view('viewcontactdata', 'Dashboard.pages.forms.managecontact')->name('managecontact'); // View to manage contacts
        Route::controller(ContactController::class)->group(function () {
            Route::post('contacts/import','import')->name('contacts.import');

            Route::get("/addcontact/{id}/edit", "editcontact")->name('edit_contact'); // Edit contact route
            Route::post("/updatecontact/{id}", "update")->name('update_contact'); // Update contact route
            Route::post("/addcontactdata", "addcontactdata")->name('add_contact_data'); // Add new contact route
            Route::post('/contacts/upload-csv', 'uploadCsv')->name('csvupload');
            Route::get('contacts', 'index')->name('contacts.index'); // List all contacts
            Route::get('contacts/edit/{id}', 'edit')->name('contacts.edit'); // Edit contact data
            Route::delete('contacts/delete/{id}', 'destroy')->name('contacts.destroy'); // Delete contact route
        });

        // //? for restoring the soft deleted data 
        // Route::get('/restoredeleted', function () {
        //     Contact::onlyTrashed()
        //         ->restore();

        //     return view("Dashboard.pages.forms.managecontact");
        // })->name("restoredeletecontact");





        //! FAQ Management Routes
        Route::get("/addfaqview", function () {
            return view("Dashboard.pages.forms.addfaq"); // View to add a new FAQ
        })->name('add_faq_view');
        Route::view('viewfaqdata', 'Dashboard.pages.forms.managefaq')->name('managefaq'); // View to manage FAQs
        Route::controller(FaqContorller::class)->group(function () {

            Route::get("/addfaq/{id}/edit", "editfaq")->name('edit_faq'); // Edit FAQ route
            Route::post("/updatefaq/{id}", "update")->name('update_faq'); // Update FAQ route
            Route::post("/addfaqdata", "addfaqdata")->name("add_faq_data"); // Add new FAQ route
            Route::get('faqs', 'index')->name('faqs.index'); // List all FAQs
            Route::get('faqs/edit/{id}', 'edit')->name('faqs.edit'); // Edit FAQ data
            Route::delete('faqs/delete/{id}', 'destroy')->name('faqs.destroy'); // Delete FAQ route
        });




        //! CMS Management Routes
        Route::get("/addcmsview", function () {
            return view("Dashboard.pages.forms.addcms"); // View to add new CMS data
        })->name('add_cms_view');
        Route::view('viewcmsdata', 'Dashboard.pages.forms.managecms')->name('managecms'); // View to manage CMS data
        Route::controller(CMSController::class)->group(function () {

            Route::get("/displaycms", "displaycms")->name("displaycms"); // Display CMS data
            Route::get("/addcms/{id}/edit", "editcms")->name('edit_cms'); // Edit CMS route
            Route::post("/updatecms/{id}", "update")->name('update_cms'); // Update CMS route
            Route::post("/addcmsdata", "addcmsdata")->name("add_cms_data"); // Add new CMS data route
            Route::get('cmss', 'index')->name('cmss.index'); // List all CMS data
            Route::get('cmss/edit/{id}', 'edit')->name('cmss.edit'); // Edit CMS data
            Route::delete('cmss/delete/{id}', 'destroy')->name('cmss.destroy'); // Delete CMS data route
        });


        //! Admin leave Management Routes    
        Route::view('viewleaveadmindata', 'Dashboard.pages.forms.manageleaveadmin')->name('manageadminleave'); // View to manage leaves
        Route::controller(LeaveController::class)->group(function () {
            Route::post('leaves/approve/{id}',  'approve')->name('leaves.approve');
            Route::post('leaves/reject/{id}',  'reject')->name('leaves.reject');
            Route::get('leavesss', 'adminindex')->name('adminleavedata'); // List all leaves
            
        
        });
        
        
        
        //! Admin Task Management Module Routes
        
        Route::view('viewtaskdata', 'Dashboard.pages.forms.managetask')->name('managetask');
        Route::controller(TaskController::class)->group(function () {
            
            Route::get('/viewusertask/{id}', 'viewusertask')->name('viewtask'); // View to manage tasks
            Route::get("/addtaskview", "showTaskForm")->name('add_task_view');
            Route::get("/addtask/{id}/edit", "edittask")->name('edit_task'); // Edit task route
            Route::post("/updatetask/{id}", "update")->name('update_task'); // Update task route
            Route::post("/addtaskdata", "addtaskdata")->name('add_task_data'); // Add new task route

            Route::get('tasks', 'index')->name('tasks.index'); // List all tasks
            Route::get('tasks/edit/{id}', 'edit')->name('tasks.edit'); // Edit task data
            Route::delete('tasks/delete/{id}', 'destroy')->name('tasks.destroy'); // Delete task route
        });
    });
    
    
    
    //! User Task Management Module routes
    Route::view('viewusertaskdata', 'Dashboard.pages.forms.manageusertask')->name('manageusertask');
    Route::controller(TaskController::class)->group(function () {
        
        Route::get('tasks/{id}/view',  'viewcomment')->name('taskscomment.view');
        Route::post('tasks/{id}/comment',  'addComment')->name('tasks.addComment');
        Route::get('/viewusertask/{id}', 'viewusertask')->name('viewtask'); // View to manage tasks
        Route::get('usertasks', 'usertaskindex')->name('usertasks.index'); // List all tasks
        Route::patch('usertasks/{task}/update-status',  'updateStatus')->name('tasks.updateStatus');
    });
    
    
    
    //! leave Management Routes    
    Route::get("/addleaveview", function () {
        return view("Dashboard.pages.forms.addleave"); // View to add a new leave
    })->name('add_leave_view');
    Route::view('viewleavedata', 'Dashboard.pages.forms.manageleave')->name('manageleave'); // View to manage leaves
    Route::controller(LeaveController::class)->group(function () {
        Route::get('/leaves/export-excel',  'exportExcel')->name('leaves.export.excel');
        Route::get('/leaves/export', 'exportToCsv')->name('leaves.export');
        Route::get("/addleave/{id}/edit", "editleave")->name('edit_leave'); // Edit leave route
        Route::post("/updateleave/{id}", "update")->name('update_leave'); // Update leave route
        Route::post("/addleavedata", "addleavedata")->name('add_leave_data'); // Add new leave route
        Route::get('leaves', 'index')->name('leaves.index'); // List all leaves
        Route::get('leaves/edit/{id}', 'edit')->name('leaves.edit'); // Edit leave data
        Route::delete('leaves/delete/{id}', 'destroy')->name('leaves.destroy'); // Delete contact route
    });


    //! Clock IN/OUT Module Routes
    Route::controller(ClockInOutController::class)->group(function () {

        Route::post('/clock-in', 'clockIn');
        Route::post('/clock-out', 'clockOut');
        Route::get("/weeklylogs", "showWeeklyLogs")->name("week_view");
        Route::get("/alllogs", "showAllLogs")->name("all_log_view");
    });



    //! Notification Routes

    Route::controller(NotificationController::class)->group(function () {
        Route::post('/mark-all-as-read', 'markAllAsRead')->name('markAllAsRead');
        Route::get('notifications/mark-as-read/{id}',  'markAsRead')->name('notifications.markAsRead');
        Route::get('notifications',  'index')->name('notifications.index');
        Route::get('notifications/count',  'getUnreadCount')->name('notifications.count');
    });

    // Route::get('/chat', [PusherController::class, 'index'])->name('chat');
    // Route::get('/users', [PusherController::class, 'users']);
    // Route::get('/messages/{userId}', [PusherController::class, 'getMessages']);
    // Route::post('/send-message', [PusherController::class, 'sendMessage']);
    
});
