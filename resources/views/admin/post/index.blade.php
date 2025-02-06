@extends('layouts.admin-app')
@section('title', 'Post List')
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
                        <th>Created By</th>
                        <th>Status</th>
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
    <script type="text/javascript">
        $(function() {
            var table = $('.user-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users-post') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]

            });
        });
    </script>
@endsection
