<x-adminheader />
@include('Dashboard.pages.forms.select2')



<body style="background-color:#F4F6FF;">
    <div class="container py-5 px-4">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-header text-center" style="background-color: #3C37A6; color: white; border-radius: 5px;">
                <h3>View All Notifications</h3>
            </div>
            <div class="card-body">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $notification)
                                <tr >
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notification->title }}</td>
                                    <td>{{ Str::limit($notification->message, 50) }}</td>
                                    <td>{{ $notification->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if (is_null($notification->read_at))
                                            <a href="{{ route('viewmodule', [
                                                'module' => $notification->type,
                                                'id' => $notification->post_id ,
                                                'notification_id' => $notification->id,
                                            ]) }}"
                                                class="btn btn-sm btn-warning text-white font-weight-bold"
                                                title="Mark as Read">
                                                Mark as Read
                                            </a>
                                        @else
                                            <!-- Dynamic route for viewing the notification -->
                                            <a href="{{ route('viewmodule', [
                                                'module' => $notification->type,
                                                'id' => $notification->post_id ,
                                                'notification_id' => $notification->id,
                                            ]) }}"
                                                class="btn btn-sm btn-primary text-white ml-2 font-weight-bold"
                                                title="View Notification">
                                                Viewed
                                            </a>
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- <!-- Pagination links -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $notifications->links() }}
                </div> --}}
            </div>
        </div>
    </div>

</body>

</html>
