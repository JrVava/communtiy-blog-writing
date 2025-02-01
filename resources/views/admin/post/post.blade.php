@extends('layouts.admin-app')
@section('title', 'Post')
@section('content')
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <!-- Profile Card -->
            <div class="col-md-12 col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1>
                            <b>{{ $post->title }}</b>
                        </h1>
                        <img src="{{ $post->image }}" class="card-img-top mx-auto mb-3 mt-3" alt="User Photo">
                        <p style="text-align: justify;">
                            {!! $post->description !!}
                        </p>
                        <div class="d-flex justify-content-center">
                            @if(!$post->is_approve)
                            <a href="{{ route('post-approve-deny',['id' => $post->id]) }}" class="btn btn-primary me-2">Approve</a>
                            @else
                                <a href="{{ route('post-approve-deny',['id' => $post->id]) }}" class="btn btn-outline-danger">Deny</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
