@extends('layouts.admin-app')
@section('title', 'User Profile')
@section('content')
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <!-- Profile Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="card-img-top rounded-circle mx-auto d-block mt-3" alt="User Photo" style="width: 150px; height: 150px;">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $user->full_name }}</h3>
                        <p class="card-text text-muted">Web Developer</p>
                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> {{ $user->email }}</li>
                            @if(isset($user->countryRecord))
                                <li><strong>Country:</strong> {{ $user->countryRecord->name }}</li>
                            @endif
                            
                            @if(isset($user->city))
                                <li><strong>City:</strong> {{ $user->city }}</li>
                            @endif
                            @if(isset($user->home_town))
                                <li><strong>Home Town:</strong> {{ $user->home_town }}</li>
                            @endif
                            @if(isset($user->university))
                                <li><strong>University:</strong> {{ $user->university }}</li>
                            @endif
                            @if(isset($user->degree))
                                <li><strong>Degress:</strong> {{ $user->degree }}</li>
                            @endif
                            @if(isset($user->passing_year))
                                <li><strong>Passing Year:</strong> {{ $user->passing_year }}</li>
                            @endif
                            @if(isset($user->working_or_business))
                                <li><strong>Work or Business:</strong> {{ $user->working_or_business }}</li>
                            @endif
                        </ul>
                        <div class="d-flex justify-content-center">
                            @if(!$user->is_approve)
                            <a href="{{ route('users-approve-deny',['id' => $user->id]) }}" class="btn btn-primary me-2">Approve</a>
                            @else
                                <a href="{{ route('users-approve-deny',['id' => $user->id]) }}" class="btn btn-outline-danger">Deny</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
