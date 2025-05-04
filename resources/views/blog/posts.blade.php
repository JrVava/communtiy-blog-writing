@foreach ($posts as $post)
    <div class="card post-card mb-4 shadow-sm rounded border-0">
        <div class="card-body">
            <!-- User Info -->
            <div class="d-flex align-items-center mb-3 justify-content-between">
                <div class="d-flex align-items-center">
                    @if ($post->user->image)
                        <img src="{{ asset('storage/' . $post->user->image) }}" class="rounded-circle border me-3"
                            width="50" height="50" alt="{{ $post->user->full_name }}">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white me-2"
                            style="width: 40px; height: 40px; font-size: 1rem; font-weight: bold;">
                            {{ $post->user->initials }}
                        </div>
                    @endif
                    <div class="text-start">
                        <h6 class="mb-1 fw-bold">{{ $post->user->full_name }}</h6>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                <!-- Dropdown for Edit/Delete -->
                @if (Route::currentRouteName() == 'profile' && $post->created_by == Auth::id())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button type="button" class="dropdown-item edit-button editPostModal" type="button"
                                    data-bs-toggle="modal" data-bs-target="#editPostModal"
                                    data-description="{{ htmlentities($post->description, ENT_QUOTES) }}"
                                     data-postImage="{{ asset('storage/' . $post->image) }}"
                                     data-old_post_image="{{$post->image}}"
                                    data-post_id="{{ $post->id }}">Edit </button>
                            </li>
                            <li><a class="dropdown-item text-danger"
                                    href="{{ route('delete-post', ['id' => $post->id]) }}">Delete</a></li>
                        </ul>
                    </div>
                @endif
            </div>


            <!-- Post Content -->
            <div class="text-start">
                <p class="card-text text-muted short-content">
                    {{ Str::limit($post->description, 150, '...') }}
                </p>
                <p class="card-text text-muted full-content d-none">
                    {{ $post->description }}
                </p>
                @if (strlen($post->description) > 150)
                    <button class="btn btn-link read-more-btn p-0" data-expanded="false">Read More</button>
                @endif
            </div>
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
                    <div class="d-flex align-items-start mb-2 text-start">
                        @if ($commentData->user->image)
                            <img src="{{ asset('storage/' . $commentData->user->image) }}"
                                class="rounded-circle border me-2" width="40" height="40"
                                alt="{{ $commentData->user->full_name }}">
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
