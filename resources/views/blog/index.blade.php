@extends('layouts.app-layout')
@section('title', 'Dashboard')
@section('content')

@php
    $user = Auth::user();
    $initials = strtoupper(substr($user->full_name, 0, 1)); // Get the first letter of full_name
@endphp
@include('blog.form')

<!-- Post Listings -->
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10 col-12">
        @include('blog.posts')
    </div>
</div>
@endsection