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
                        <th>Full Name</th>
                        <th>Email</th>
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
                ajax: "{{ route('users') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
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
