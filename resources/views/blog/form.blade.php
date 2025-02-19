<div class="row mb-4 justify-content-center">
    <div class="col-xl-8 col-lg-10 col-12">
        <div class="card mb-3 shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <!-- Profile Picture -->
                    @if ($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle me-2"
                            width="50" height="50" alt="User Profile">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white me-2"
                            style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold;">
                            {{ $initials }}
                        </div>
                    @endif
                    <h5 class="mb-0">Create a Post</h5>
                </div>

                <form action="{{ route('create-post') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Post Content -->
                    <div class="mb-3">
                        <textarea class="form-control border-0 shadow-none" name="description" id="postContent" rows="3"
                            placeholder="What's on your mind?" style="resize: none; font-size: 1.1rem;"></textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="postImage" class="form-label d-flex align-items-center">
                            <i class="bi bi-image text-primary me-2" style="font-size: 1.3rem;"></i>
                            <span class="text-muted">Add Photo/Video</span>
                        </label>
                        <input type="file" class="form-control d-none" id="postImage" name="image">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill">
                            <i class="bi bi-send"></i> Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    textarea:focus {
        outline: none !important;
        box-shadow: none !important;
    }
</style>
