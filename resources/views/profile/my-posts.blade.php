@foreach ($posts as $post)
    <div class="post mb-4 p-3 border rounded">
        <div class="d-flex justify-content-between">
            <div class="d-flex">
                @if ($user->image)
                    <img src="{{ asset('uploads/profile/' . $user->image) }}" class="rounded-circle me-3"
                        alt="User Profile" style="width: 50px; height: 50px;">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white me-2"
                        style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold;">
                        {{ $initials }}
                    </div>
                @endif
                <div>
                    <h6 class="mb-1 fw-bold">{{ $post->user->full_name }}</h6>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>
            </div>
            <!-- Three Dots (More Options) -->
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Edit</a></li>
                    <li><a class="dropdown-item" href="#">Delete</a></li>
                    <li><a class="dropdown-item" href="#">Report</a></li>
                </ul>
            </div>
        </div>

        @if ($post->image)
            <div class="mt-3">
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded" alt="{{ $user->full_name }}"
                    style="max-height: 400px; object-fit: cover;">
            </div>
        @endif

        <p class="card-text text-muted short-content mt-3">
            {{ Str::limit($post->description, 150, '...') }}
        </p>
        <p class="card-text text-muted full-content d-none mt-3">
            {{ $post->description }}
        </p>
        @if (strlen($post->description) > 150)
            <button class="btn btn-link read-more-btn p-0" data-expanded="false">Read More</button>
        @endif

        <div class="d-flex justify-content-between mt-3">
            <button class="btn btn-outline-primary btn-sm">Like</button>
            <button class="btn btn-outline-secondary btn-sm">Comment</button>
            <button class="btn btn-outline-success btn-sm">Share</button>
        </div>
    </div>
@endforeach

@section('scripts')
    <script>
        $(document).ready(function() {
            // Read More / Read Less Toggle
            $(".read-more-btn").click(function() {
                let isExpanded = $(this).attr("data-expanded") === "true";
                let card = $(this).closest(".post");

                if (!isExpanded) {
                    card.find(".short-content").hide();
                    card.find(".full-content").removeClass("d-none");
                    $(this).text("Read Less");
                } else {
                    card.find(".short-content").show();
                    card.find(".full-content").addClass("d-none");
                    $(this).text("Read More");
                }

                $(this).attr("data-expanded", !isExpanded);
            });
        });
    </script>
@endsection
