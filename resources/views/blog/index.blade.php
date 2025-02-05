@extends('layouts.app-layout')
@section('title', 'Dashboard')
@section('content')

@php
    $user = Auth::user();
    $initials = strtoupper(substr($user->full_name, 0, 1)); // Get the first letter of full_name
@endphp
@include('blog.form')

<!-- Post Listings -->
<div class="row">
    <div class="col-md-8 offset-md-2">
        @include('blog.posts')
    </div>
</div>
@endsection