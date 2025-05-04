<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editPostForm" method="post" action="{{ route('update-post') }}" enctype="multipart/form-data" class="editPostForm">
                @csrf
                <input type="hidden" class="form-control" name="id" id="editPostId">

                <div class="modal-header">
                    <h5 class="modal-title" id="editPostLabel">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3 text-start d-none" id="editImagePreviewContainer">
                        <div class="position-relative">
                            <img id="editImagePreview" src="" class="img-fluid rounded border" style="width: 100%;" />
                        </div>
                    </div>
                    <div class="mb-3 text-start">
                        <textarea class="form-control border-0 shadow-none" name="description" id="editPostDescription" rows="3"
                            placeholder="What's on your mind?" style="resize: none; font-size: 1.1rem;"></textarea>
                    </div>

                    <div class="mb-3">
                        <input type="hidden" name="old_post_image" id="editOldPostImage">
                        <input type="file" class="form-control" id="postImage" name="image">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ✅ Image Preview -->
                    
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
