@extends('layouts.admin-app')
@section('title', 'User Lists')
@section('content')
    <div class="container-fluid p-0">
        <div class="card p-4">
            <div class="card-header">
                <h1 class="h3 mb-3"><strong>User</strong> List</h1>
            </div>
            <table class="table m-0 user-data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Manage Status</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(function() {
            var table = $('.user-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users') }}",
                pageLength: 25, // Set default to 25 records per page
                lengthMenu: [10, 25, 50, 100], // Optional: Define dropdown menu options
                columns: [
                    //             {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    //     orderable: false,
                    //     searchable: false,
                    //     title: '#'
                    // }    
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'approve_switch',
                        name: 'approve_switch',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]

            });
            $('.user-data-table').on('change', '.approve-switch', function() {
                var userId = $(this).data('user-id');
                var isApproved = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('admin.users.approve') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: userId,
                        is_approve: isApproved
                    },
                    success: function(response) {
                        table.ajax.reload();
                        toastr.success('User approval status updated successfully');
                    },
                    error: function(xhr) {
                        table.ajax.reload();
                        toastr.error('Error updating approval status');
                    }
                });
            });
        });
    </script>
@endsection
