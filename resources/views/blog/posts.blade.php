@foreach($posts as $post)
<div class="card post-card mb-4 shadow-sm rounded">
    <div class="card-body">
        <!-- User Info -->
        <div class="d-flex align-items-center mb-3">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" 
                 class="rounded-circle border me-3"
                 width="50" height="50"
                 alt="User Image">
            <div>
                <h6 class="mb-1 fw-bold">{{ $post->user->full_name }}</h6>
                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
            </div>
        </div>

        <!-- Post Title -->
        <h5 class="fw-semibold text-dark">{{ $post->title }}</h5>

        <!-- Post Image -->
        @if($post->image)
        <div class="mb-3">
            <img src="{{ $post->image }}" class="img-fluid rounded" alt="Post Image">
        </div>
        @endif

        <!-- Post Content with "Read More" -->
        <p class="card-text text-muted short-content">
            {{ Str::limit($post->description, 150, '...') }}
        </p>
        <p class="card-text text-muted full-content d-none">
            {{ $post->description }}
        </p>
        @if(strlen($post->description) > 150)
        <button class="btn btn-link read-more-btn p-0" data-expanded="false">Read More</button>
        @endif

        <!-- Like & Dislike Buttons with Icons Only -->
        <div class="d-flex gap-2 mt-3">
            <button class="btn btn-light border btn-sm like-btn" data-liked="false">
                <i class="bi bi-hand-thumbs-up"></i>
            </button>
            <button class="btn btn-light border btn-sm dislike-btn" data-disliked="false">
                <i class="bi bi-hand-thumbs-down"></i>
            </button>
            <button class="btn btn-light border btn-sm">
                <i class="bi bi-chat"></i>
            </button>
        </div>
    </div>
</div>
@endforeach

<!-- jQuery Script for Read More & Like/Dislike Buttons -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // Read More / Read Less Toggle
    $(".read-more-btn").click(function(){
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

    // Like & Dislike Toggle with Icons Only
    $(".like-btn").click(function(){
        let isLiked = $(this).attr("data-liked") === "true";
        let dislikeBtn = $(this).siblings(".dislike-btn");

        if (!isLiked) {
            $(this).addClass("btn-primary").removeClass("btn-light");
            $(this).find(".bi").addClass("bi-hand-thumbs-up-fill").removeClass("bi-hand-thumbs-up");

            // Reset dislike button if previously selected
            dislikeBtn.removeClass("btn-danger").addClass("btn-light");
            dislikeBtn.find(".bi").removeClass("bi-hand-thumbs-down-fill").addClass("bi-hand-thumbs-down");
            dislikeBtn.attr("data-disliked", "false");

        } else {
            $(this).removeClass("btn-primary").addClass("btn-light");
            $(this).find(".bi").removeClass("bi-hand-thumbs-up-fill").addClass("bi-hand-thumbs-up");
        }

        $(this).attr("data-liked", !isLiked);
    });

    $(".dislike-btn").click(function(){
        let isDisliked = $(this).attr("data-disliked") === "true";
        let likeBtn = $(this).siblings(".like-btn");

        if (!isDisliked) {
            $(this).addClass("btn-danger").removeClass("btn-light");
            $(this).find(".bi").addClass("bi-hand-thumbs-down-fill").removeClass("bi-hand-thumbs-down");

            // Reset like button if previously selected
            likeBtn.removeClass("btn-primary").addClass("btn-light");
            likeBtn.find(".bi").removeClass("bi-hand-thumbs-up-fill").addClass("bi-hand-thumbs-up");
            likeBtn.attr("data-liked", "false");

        } else {
            $(this).removeClass("btn-danger").addClass("btn-light");
            $(this).find(".bi").removeClass("bi-hand-thumbs-down-fill").addClass("bi-hand-thumbs-down");
        }

        $(this).attr("data-disliked", !isDisliked);
    });
});
</script>
