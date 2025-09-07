@if ($user->id == Auth::id())
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <img src="@if (isset($currentProfileImage)) {{ Storage::url($currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
                    alt="User Avatar" class="w-10 h-10 rounded-full object-cover border border-gray-200">
            </div>
            <div class="flex-1">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <textarea placeholder="What's on your mind?" name="content"
                        class="w-full p-3 border-0 focus:ring-0 resize-none text-gray-700 placeholder-gray-500 @error('content') border-red-500 @enderror"
                        rows="3"></textarea>
                    @error('content')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                    <div class="image-preview-container">
                        <img id="imagePreview" src="#" alt="Preview">
                        <div class="remove-image-btn" onclick="removeImage()">
                            <i class="fas fa-times text-xs"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-3">
                        <div class="relative">
                            <input type="file" id="imageUpload" name="media" accept="image/*,video/*"
                                class="hidden" onchange="previewImage(this)">
                            <label for="imageUpload"
                                class="flex items-center text-gray-500 hover:bg-[#374697d9] hover:text-white rounded-md px-3 py-1 cursor-pointer">
                                <i class="fas fa-image text-green-500 mr-2"></i>
                                <span>Photo/Video</span>
                            </label>
                            @error('media')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit"
                            class="bg-[#374697] hover:bg-[#374697d9] text-white px-4 py-1 rounded-md font-medium">
                            Post <i class="fas fa-paper-plane text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
