<div class="row mb-4">
    <div class="col-md-8 offset-md-2">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Create a New Post</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('create-post') }}" method="post" enctype="multipart/form-data"> <!-- Added enctype for file upload -->
                    @csrf
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="postTitle" name="title" placeholder="Enter post title">
                    </div>
                    <div class="mb-3">
                        <label for="postContent" class="form-label">Content</label>
                        <textarea class="form-control" name="description" id="postContent" rows="4" placeholder="Write your post here..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="postImage" class="form-label">Upload an Image (optional)</label>
                        <input type="file" class="form-control" id="postImage" name="image"> <!-- File input for image -->
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Post
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
