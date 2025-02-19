@foreach ($posts as $post)
    <div class="card post-card mb-4 shadow-sm rounded border-0">
        <div class="card-body">
            <!-- User Info -->
            <div class="d-flex align-items-center mb-3">
                @if ($post->user->image)
                    <img src="{{ asset('storage/' . $post->user->image) }}" class="rounded-circle border me-3"
                        width="50" height="50" alt="{{ $post->user->full_name }}">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white me-2"
                        style="width: 40px; height: 40px; font-size: 1rem; font-weight: bold;">
                        {{ $post->user->initials }}
                    </div>
                @endif
                <div>
                    <h6 class="mb-1 fw-bold">{{ $post->user->full_name }}</h6>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>
            </div>

            <!-- Post Content -->
            <p class="card-text text-muted short-content">
                {{ Str::limit($post->description, 150, '...') }}
            </p>
            <p class="card-text text-muted full-content d-none">
                {{ $post->description }}
            </p>
            @if (strlen($post->description) > 150)
                <button class="btn btn-link read-more-btn p-0" data-expanded="false">Read More</button>
            @endif

            <!-- Post Image -->
            @if ($post->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded w-100"
                        alt="{{ $post->user->full_name }}" style="max-height: 450px; object-fit: cover;">
                </div>
            @endif

            <!-- Reactions (Like, Comment, Share) -->
            <div class="d-flex px-3 py-2 border-top">
                <button class="btn btn-sm like-btn me-2 {{ $post->user_liked ? 'btn-primary' : 'btn-light' }}"
                    data-liked="{{ $post->user_liked ? 'true' : 'false' }}" data-post-id="{{ $post->id }}"
                    data-posted-id="{{ $post->created_by }}">
                    <i class="bi {{ $post->user_liked ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }}"></i>
                </button>
                <i id="#likes-count-{{ $post->id }}"></i>

                <button class="btn btn-sm dislike-btn me-2 {{ $post->user_disliked ? 'btn-danger' : 'btn-light' }}"
                    data-disliked="{{ $post->user_disliked ? 'true' : 'false' }}" data-post-id="{{ $post->id }}"
                    data-posted-id="{{ $post->created_by }}">
                    <i class="bi {{ $post->user_disliked ? 'bi-hand-thumbs-down-fill' : 'bi-hand-thumbs-down' }}"></i>
                </button>
                <i id="#dislikes-count-{{ $post->id }}"></i>

                <button class="btn btn-light btn-sm comment-btn">
                    <i class="bi bi-chat"></i> Comment
                </button>
            </div>

            <!-- Comment Section -->
            <div class="comments-section mt-3 d-none">
                @foreach ($post->comments->sortBy('created_at') as $commentData)
                    <div class="d-flex align-items-start mb-2">
                        @if ($commentData->user->image)
                            <img src="{{ asset('storage/' . $commentData->user->image) }}"
                                class="rounded-circle border me-2" width="40" height="40" alt="{{ $commentData->user->full_name }}">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white me-2"
                                style="width: 40px; height: 40px; font-size: 1rem; font-weight: bold;">
                                {{ $commentData->user->initials }}
                            </div>
                        @endif
                        <div class="bg-light p-2 rounded w-100">
                            <h6 class="mb-1 fw-bold">{{ $commentData->user->full_name }}</h6>
                            <p class="comment-text mb-1">{{ $commentData->comment }}</p>
                            <small class="text-muted">{{ $commentData->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
                <div class="comment-block"></div>
            </div>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control form-control-sm rounded-pill send-comment"
                    placeholder="Write a comment..." data-post-id="{{ $post->id }}"
                    data-posted-id="{{ $post->created_by }}">
                <button class="btn btn-primary btn-sm ms-2 rounded-circle send-comment-btn">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </div>
    </div>
@endforeach

<!-- jQuery for Interactions -->
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.comment-btn').on('click', function() {
                let commentSection = $(this).closest('.d-flex').next('.comments-section');
                commentSection.toggleClass('d-none');
            });

            $(".read-more-btn").click(function() {
                let isExpanded = $(this).attr("data-expanded") === "true";
                let card = $(this).closest(".card-body");

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

            $(".like-btn").click(function() {
                let postId = $(this).data("post-id");
                let isLiked = $(this).attr("data-liked") === "true";
                let dislikeBtn = $(this).siblings(".dislike-btn");
                let postedId = $(this).data('posted-id')
                // Toggle UI
                if (!isLiked) {
                    $(this).addClass("btn-primary").removeClass("btn-light");
                    $(this).find("i").addClass("bi-hand-thumbs-up-fill").removeClass("bi-hand-thumbs-up");

                    // Reset dislike button if selected
                    dislikeBtn.removeClass("btn-danger").addClass("btn-light");
                    dislikeBtn.find(".bi").removeClass("bi-hand-thumbs-down-fill").addClass(
                        "bi-hand-thumbs-down");
                    dislikeBtn.attr("data-disliked", "false");
                } else {
                    $(this).removeClass("btn-primary").removeClass("active").addClass("btn-light");
                    $(this).find("i").removeClass("bi-hand-thumbs-up-fill").addClass("bi-hand-thumbs-up");
                }

                $(this).attr("data-liked", !isLiked);

                // AJAX request to Laravel
                $.ajax({
                    url: `/post/${postId}/like`,
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response.data.likes.length);
                        console.log("dislikes", response.data.dislikes.length);
                        $("#likes-count-" + postId).text(response.data.likes.length);
                        $("#dislikes-count-" + postId).text(response.data.dislikes.length);

                        let notification = JSON.stringify({
                            type: "get_notification",
                            userId: postedId
                        });

                        if (socket.readyState === WebSocket.OPEN) {
                            socket.send(notification);
                        } else {
                            console.warn("⚠️ WebSocket not open yet");
                        }
                    }
                });
            });


            $(".dislike-btn").click(function() {
                let postId = $(this).data("post-id");
                let isDisliked = $(this).attr("data-disliked") === "true";
                let likeBtn = $(this).siblings(".like-btn");
                let postedId = $(this).data('posted-id')
                // Toggle UI
                if (!isDisliked) {
                    $(this).addClass("btn-danger").removeClass("btn-light");
                    $(this).find("i").addClass("bi-hand-thumbs-down-fill").removeClass(
                        "bi-hand-thumbs-down");

                    // Reset like button if selected
                    likeBtn.removeClass("btn-primary").addClass("btn-light");
                    likeBtn.find(".bi").removeClass("bi-hand-thumbs-up-fill").addClass("bi-hand-thumbs-up");
                    likeBtn.attr("data-liked", "false");
                } else {
                    $(this).removeClass("btn-danger").removeClass("active").addClass("btn-light");
                    $(this).find("i").removeClass("bi-hand-thumbs-down-fill").addClass(
                        "bi-hand-thumbs-down");
                }

                $(this).attr("data-disliked", !isDisliked);

                // AJAX request to Laravel
                $.ajax({
                    url: `/post/${postId}/dislike`,
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#likes-count-" + postId).text(response.data.likes.length);
                        $("#dislikes-count-" + postId).text(response.data.dislikes.length);
                        let notification = JSON.stringify({
                            type: "get_notification",
                            userId: postedId
                        });

                        if (socket.readyState === WebSocket.OPEN) {
                            socket.send(notification);
                        } else {
                            console.warn("⚠️ WebSocket not open yet");
                        }
                    }
                });
            });

            $(".send-comment-btn").click(function() {
                let commentInput = $(this).siblings(".send-comment");
                let postId = commentInput.data('post-id');
                let postedId = commentInput.data('posted-id')
                let userId = "{{ Auth::user()->id }}"
                let message = commentInput.val().trim();

                if (message !== "") {
                    let commentSection = $(this).closest(".comments-section");
                    let commentBlock = commentSection.find(".comment-block");
                    $.ajax({
                        url: "{{ route('save-comment') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            postId: postId,
                            userId: userId,
                            message: message
                        },
                        success: function(res) {
                            console.log(res);
                        }
                    })
                    let newComment = `
                        <div class="d-flex align-items-start mb-2">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                class="rounded-circle border me-2" width="40" height="40" alt="User Image">
                            <div class="bg-light p-2 rounded w-100">
                                <h6 class="mb-1 fw-bold">Ashish</h6>
                                <p class="comment-text mb-1">${message}</p>
                                <small class="text-muted">Just now</small>
                            </div>
                        </div>
                    `;
                    // Append the new comment
                    commentBlock.append(newComment);
                    commentInput.val("");

                    let notification = JSON.stringify({
                        type: "get_notification",
                        userId: postedId
                    });

                    if (socket.readyState === WebSocket.OPEN) {
                        socket.send(notification);
                    } else {
                        console.warn("⚠️ WebSocket not open yet");
                    }
                } else {
                    console.log("No comment entered.");
                }
            });

            $(".send-comment").keypress(function(e) {
                if (e.which === 13) {
                    $(this).siblings(".send-comment-btn").click();
                }
            });


        });
    </script>
@endsection
