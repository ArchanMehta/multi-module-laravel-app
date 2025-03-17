<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'Skydash Admin' }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('dashboard/images/favicon.png') }}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="{{ route('index') }}"><img
                        src="{{ asset('dashboard/images/logo.svg') }}" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="{{ route('index') }}"><img
                        src="{{ asset('dashboard/images/logo-mini.svg') }}" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                <span class="input-group-text" id="search">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                                aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                            data-toggle="dropdown">
                            <i class="icon-bell mx-0" style="font-size:23px;height:4px"></i>
                            <span class="count" style="height: 29px;width:24px;color:whitesmoke">
                                {{ auth()->user()->unreadNotifications()->count() }}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <p class="mb-0 font-weight-normal dropdown-header">Notifications</p>
                                <a href="javascript:void(0)" id="markAllAsRead" class="text-decoration-none"
                                    style="color: #4B49AC; font-size: 14px;" onmouseover="this.style.color='#6A67CE'"
                                    onmouseout="this.style.color='#4B49AC'">
                                    Mark All as Read
                                </a>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('#markAllAsRead').click(function() {
                                        // Show loading indicator if desired (optional)
                                        $(this).text('Marking all as read...').css('color', 'grey');

                                        $.ajax({
                                            url: '{{ route('markAllAsRead') }}', // The route that handles the marking
                                            method: 'POST', // Use POST to avoid modifying the URL in a GET request
                                            data: {
                                                _token: '{{ csrf_token() }}', // Include CSRF token for security
                                            },
                                            success: function(response) {
                                                // On success, update the notifications UI accordingly
                                                if (response.status === 'success') {

                                                    location.reload(); // Optionally reload to reflect changes
                                                } else {
                                                    alert('An error occurred while marking notifications.');
                                                }
                                            },
                                            error: function() {
                                                alert('Error while making AJAX request.');
                                            }
                                        });
                                    });
                                });
                            </script>



                            <div style="overflow-y: scroll;max-height:400px;min-width:350px">
                                @foreach (auth()->user()->unreadNotifications as $notification)
                                    <a class="dropdown-item preview-item"
                                        href="{{ route('viewmodule', [
                                            'module' => $notification->type,
                                            'id' => $notification->post_id ?? 0, // If post_id is null, default to 0
                                            'notification_id' => $notification->id,
                                        ]) }}">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-info">
                                                <i class="ti-user mx-0"></i>
                                            </div>
                                        </div>
                                        <div class="preview-item-content">
                                            <!-- Title -->
                                            <h6 class="preview-subject font-weight-normal">
                                                {{ $notification->title ?? 'No Title Available' }}
                                            </h6>

                                            <!-- Message -->
                                            <p class="font-weight-light small-text mb-0 text-muted">
                                                {{ $notification->message ?? 'No Message Available' }}
                                            </p>

                                            <!-- Description -->
                                            @if (!empty($notification->description))
                                                <p class="font-weight-light small-text mb-0 text-muted">
                                                    {{ $notification->description }}
                                                </p>
                                            @endif

                                            <!-- Timestamp -->
                                            <small class="text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <!-- View All Notifications Link -->
                            <div class="text-center mt-2">
                                <a href="{{ route('notifications.index') }}" class="text-decoration-none"
                                    style="color: #4B49AC; font-size: 14px;" onmouseover="this.style.color='#6A67CE'"
                                    onmouseout="this.style.color='#4B49AC'">
                                    View All Notifications
                                </a>
                            </div>
                        </div>
                    </li>


                    <li>
                        <x-clockinout />
                    </li>


                    <li class="nav-item nav-profile dropdown flex w-100">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown"
                            style="display: flex;justify-content:centre;align-items:center">
                            <!-- User Profile Picture -->
                            <img src="{{ asset('dashboard/images/faces/face28.jpg') }}" alt="profile" />
                            <span class="ms-2">{{ Auth::user()->name }}</span> <!-- Display User's Name -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <!-- Profile Edit Link -->
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="ti-settings text-primary"></i>
                                Profile
                            </a>

                            <a class="dropdown-item" href="{{ route('updatepassword') }}">
                                <i class="ti-settings text-primary"></i>
                                Update Password
                            </a>

                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="ti-power-off text-primary"></i>
                                    Logout
                                </a>
                            </form>
                        </div>
                    </li>

                    <li class="nav-item nav-settings d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            <i class="icon-ellipsis"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper" style="margin: -10px">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section"
                            role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab"
                            aria-controls="chats-section">CHATS</a>
                    </li>
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel"
                        aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input"
                                        placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn"
                                        id="add-task">Add</button>
                                </div>
                            </form>
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Team review meeting at 3.00 PM
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Prepare for presentation
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Resolve all the low priority tickets due today
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked>
                                            Schedule meeting for next week
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked>
                                            Project review
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                            </ul>
                        </div>
                        <h4 class="px-3 text-muted mt-5 font-weight-light mb-0">Events</h4>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="ti-control-record text-primary mr-2"></i>
                                <span>Feb 11 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
                            <p class="text-gray mb-0">The total number of sessions</p>
                        </div>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="ti-control-record text-primary mr-2"></i>
                                <span>Feb 7 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                            <p class="text-gray mb-0 ">Call Sarah Graves</p>
                        </div>
                    </div>
                    <!-- To do section tab ends -->
                    <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
                            <small
                                class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">See
                                All</small>
                        </div>
                        <ul class="chat-list">
                            <li class="list active">
                                <div class="profile"><img src="{{ asset('dashboard/images/faces/face1.jpg') }}"
                                        alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Thomas Douglas</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">19 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('dashboard/images/faces/face2.jpg') }}"
                                        alt="image"><span class="offline"></span></div>
                                <div class="info">
                                    <div class="wrapper d-flex">
                                        <p>Catherine</p>
                                    </div>
                                    <p>Away</p>
                                </div>
                                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                                <small class="text-muted my-auto">23 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ 'dashboard/images/faces/face3.jpg' }}"
                                        alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Daniel Russell</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">14 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('dashboard/images/faces/face4.jpg') }}"
                                        alt="image"><span class="offline"></span></div>
                                <div class="info">
                                    <p>James Richardson</p>
                                    <p>Away</p>
                                </div>
                                <small class="text-muted my-auto">2 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('dashboard/images/faces/face5.jpg') }}"
                                        alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Madeline Kennedy</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">5 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="{{ asset('dashboard/images/faces/face6.jpg') }}"
                                        alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Sarah Graves</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">47 min</small>
                            </li>
                        </ul>
                    </div>
                    <!-- chat tab ends -->
                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <!-- Common Dashboard Link for both Admin and User -->

                    {{-- Admin Menu --}}
                    @if (auth()->check() && auth()->user()->role == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index') }}">
                                <i class="icon-grid menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('manageuser') }}">
                                <i class="ti-settings menu-icon"></i>
                                <span class="menu-title">Manage User</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('managerole') }}">
                                <i class="ti-settings menu-icon"></i>
                                <span class="menu-title">Manage Role</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('managecontact') }}">
                                <i class="ti-settings menu-icon"></i>
                                <span class="menu-title">Manage Contact</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('managecms') }}">
                                <i class="ti-settings menu-icon"></i>
                                <span class="menu-title">CMS</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#leaveadminmenu" aria-expanded="false"
                                aria-controls="auth">
                                <i class="icon-layout menu-icon"></i>
                                <span class="menu-title">Manage Leaves</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="leaveadminmenu">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('manageadminleave') }}">Manage Leave</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (auth()->check() && auth()->user()->role !== 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index') }}">
                                <i class="icon-grid menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#leavemenu" aria-expanded="false"
                                aria-controls="auth">
                                <i class="icon-layout menu-icon"></i>
                                <span class="menu-title">Manage Leaves</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="leavemenu">
                                <ul class="nav flex-column sub-menu">

                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('add_leave_view') }}">Apply for Leave</a></li>

                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('manageleave') }}">Manage Leave</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    {{-- In Out Module  --}}
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#inout" aria-expanded="false"
                            aria-controls="auth">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">IN/OUT Register</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="inout">
                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"><a class="nav-link" href="{{ route('week_view') }}">Weekly
                                        Logs</a></li>

                                <li class="nav-item"><a class="nav-link" href="{{ route('all_log_view') }}">All
                                        Logs</a></li>
                            </ul>
                        </div>
                    </li>
                    {{-- Task Management Module  --}}
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#taskmanagement" aria-expanded="false"
                            aria-controls="auth">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Task Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="taskmanagement">
                            <ul class="nav flex-column sub-menu">
                                @if (auth()->check() && auth()->user()->role == 'Admin')
                                    <li class="nav-item"><a class="nav-link" href="{{ route('managetask') }}">Manage
                                            Tasks</a></li>
                                @else
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('manageusertask') }}">Tasks</a>
                                        {{-- <li class="nav-item"><a class="nav-link" href="{{ route('displayfaq') }}">FAQ's</a> --}}
                                @endif

                            </ul>
                        </div>
                    </li>


                    {{--! for chat module  --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('chat') }}">
                            <i class="ti-settings menu-icon"></i>
                            <span class="menu-title">Chat</span>
                        </a>
                    </li> --}}



                    {{-- User FAQ Menu (Available for both Admin and User) --}}
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#faqmenu" aria-expanded="false"
                            aria-controls="auth">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">User FAQ</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="faqmenu">
                            <ul class="nav flex-column sub-menu">
                                @if (auth()->check() && auth()->user()->role == 'Admin')
                                    <li class="nav-item"><a class="nav-link" href="{{ route('managefaq') }}">Manage
                                            FAQ</a></li>
                                @endif
                                <li class="nav-item"><a class="nav-link" href="{{ route('displayfaq') }}">FAQ's</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- User Operations Menu (Available for both Admin and User) --}}
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false"
                            aria-controls="auth">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">User Operations</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="auth">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('profile.edit') }}">Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('updatepassword') }}">Update
                                        Password</a></li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="nav-link"
                                            style="background: none; border: none; cursor: pointer;">
                                            Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Additional links can go here --}}
                </ul>
            </nav>
