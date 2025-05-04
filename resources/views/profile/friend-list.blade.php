@foreach ($friendFollowLists as $friend)
    <div class="col-6 col-md-4 col-lg-6 mt-3">
        <div class="list-group-item d-flex align-items-center justify-content-between p-4">
            <div class="d-flex align-items-center">
                <img src="{{ asset('storage/' . $friend['image']) }}" alt="{{ $friend['name'] }}" class="rounded-circle"
                    style="width: 60px; height: 60px; object-fit: cover;">
                <div class="ms-3">
                    <h6 class="mb-0">{{ $friend['name'] }}</h6>
                    @if (isset($friend['location']))
                        <small class="text-muted">From {{ $friend['location'] }}</small>
                    @endif
                </div>
            </div>
            @if ($friend['status'] === 'Followed' || $friend['status'] === 'Accepted')
                <a class="btn btn-primary btn-sm" href="{{ route('unfollow', ['id' => $friend['id']]) }}">Unfollow</a>
            @elseif ($friend['status'] === 'Pending')
                <a class="btn btn-secondary btn-sm" href="{{ route('unfollow', ['id' => $friend['id']]) }}">Cancel Follow Request</a>
            @endif

        </div>
    </div>
@endforeach
@if($friendFollowLists->count() < 1)
    <h1>No Friends</h1>
@endif