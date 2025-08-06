@extends('layouts.admin-app')
@section('title', 'User Profile')
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <!-- Profile Card -->
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-3 overflow-hidden">
                    <!-- Profile Header with Gradient Background -->
                    <div class="profile-header bg-gradient-primary py-4 text-center text-white">
                        <div class="position-relative" style="height: 80px;">
                            <img src="@if (isset($currentProfileImage)) {{ Storage::url($currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
                                class="rounded-circle border border-4 border-white shadow-sm mx-auto d-block position-absolute top-100 start-50 translate-middle"
                                alt="User Photo" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        
                    </div>

                    <div class="card-body pt-5">
                        <h2 class="mb-1 fw-bold" style="text-align: center; margin-bottom: 18px !important;">{{ $user->full_name }}</h2>
                        <div class="mb-4">
                            <h5 class="card-title text-primary mb-3 border-bottom pb-2">Basic Information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Email:</span>
                                    <span>{{ $user->email }}</span>
                                </li>
                                @if (isset($relationShip))
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Relationship:</span>
                                    <span class="badge bg-info">{{ $relationShip->status }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Location Section -->
                        <div class="mb-4">
                            <h5 class="card-title text-primary mb-3 border-bottom pb-2">Location</h5>
                            <div class="row">
                                @if (isset($homeTown))
                                <div class="col-md-6">
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Home Town</h6>
                                            <p class="card-text">
                                                <i class="bi bi-house-door-fill me-2"></i>
                                                {{ $homeTown->city }}, {{ $homeTown->state }}, {{ $homeTown->country }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if (isset($currentCity))
                                <div class="col-md-6">
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Current Place</h6>
                                            <p class="card-text">
                                                <i class="bi bi-geo-alt-fill me-2"></i>
                                                {{ $currentCity->city }}, {{ $currentCity->state }}, {{ $currentCity->country }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Education Section -->
                        @if (isset($educations))
                        <div class="mb-4">
                            <h5 class="card-title text-primary mb-3 border-bottom pb-2">Education</h5>
                            <div class="timeline">
                                @foreach ($educations as $education)
                                <div class="timeline-item mb-4">
                                    <div class="timeline-badge bg-primary"></div>
                                    <div class="timeline-content p-3 bg-light rounded-3">
                                        <h6 class="fw-bold mb-1">{{ $education->degree }}</h6>
                                        <p class="mb-1 text-muted">{{ $education->school }}</p>
                                        @if ($education->field_of_study)
                                        <p class="mb-1"><small class="text-muted">{{ $education->field_of_study }}</small></p>
                                        @endif
                                        <p class="mb-0">
                                            <small class="text-primary">
                                                {{ $education->start_date->format('Y') }} - 
                                                {{ $education->end_date ? $education->end_date->format('Y') : 'Present' }}
                                            </small>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Work Experience Section -->
                        @if (isset($works))
                        <div class="mb-4">
                            <h5 class="card-title text-primary mb-3 border-bottom pb-2">Work Experience</h5>
                            <div class="timeline">
                                @foreach ($works as $work)
                                <div class="timeline-item mb-4">
                                    <div class="timeline-badge bg-success"></div>
                                    <div class="timeline-content p-3 bg-light rounded-3">
                                        <h6 class="fw-bold mb-1">{{ $work->position }}</h6>
                                        <p class="mb-1 text-muted">{{ $work->company }}</p>
                                        <p class="mb-1">
                                            <small class="text-muted">
                                                {{ $work->start_date->format('M Y') }} - 
                                                {{ $work->is_current ? 'Present' : ($work->end_date ? $work->end_date->format('M Y') : 'Present') }}
                                                · {{ $work->duration }}
                                            </small>
                                        </p>
                                        @if ($work->location)
                                        <p class="mb-0">
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt-fill me-1"></i>{{ $work->location }}
                                            </small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-center mt-4">
                            @if (!$user->is_approve)
                                <a href="{{ route('admin.users-approve-deny', ['id' => $user->id]) }}"
                                    class="btn btn-primary me-2 px-4 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-check-circle-fill me-2"></i>Approve
                                </a>
                            @else
                                <a href="{{ route('admin.users-approve-deny', ['id' => $user->id]) }}"
                                    class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-x-circle-fill me-2"></i>Deny
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Timeline -->
    <style>
        @if (isset($currentCoverImage))
        .profile-header {
            background-image: url("{{ Storage::url($currentCoverImage->path) }} ");
            background-size: cover; background-position: center;
        }
        @else
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        @endif
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 15px;
        }
        
        .timeline-badge {
            position: absolute;
            left: -15px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            z-index: 1;
        }
        
        .timeline-content {
            position: relative;
            margin-left: 10px;
        }
        
        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: -6px;
            top: 20px;
            height: calc(100% - 20px);
            width: 2px;
            background: #dee2e6;
        }
    </style>
@endsection