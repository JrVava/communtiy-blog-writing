<div id="myModal" class="w-full fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-xl max-w-[80%] w-full">
        <div class="flex justify-between items-center mb-4">
            <div class="flex-shrink-0">
                <img src="@if (isset($currentProfileImage)) {{ Storage::url($currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
                    alt="User Avatar" class="w-10 h-10 rounded-full object-cover border border-gray-200">
            </div>
            <button onclick="document.getElementById('myModal').classList.add('hidden')"
                class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex items-start space-x-3">

                    <div class="flex-1 ">

                        <textarea placeholder="What's on your mind?" name="content" id="content"
                            class="w-full h-full min-h-[400px] p-3 border-0 focus:ring-0 resize-none text-gray-700 placeholder-gray-500 @error('content') border-red-500 @enderror"
                            rows="3"></textarea>
                        @error('content')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <div class="edit-image-preview-container">
                            <img id="editImagePreview" src="#" alt="Preview">
                            <div class="edit-remove-image-btn" onclick="editRemoveImage()">
                                <i class="fas fa-times text-xs"></i>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between border-t border-gray-200 pt-3 md:flex-nowrap flex-wrap">
                            <div class="relative">
                                <input type="file" id="editImageUpload" name="media" accept="image/*,video/*"
                                    class="hidden" onchange="editPreviewImage(this)">
                                <label for="editImageUpload"
                                    class="flex items-center text-gray-500 hover:bg-[#374697d9] hover:text-white rounded-md px-3 py-1 cursor-pointer">
                                    <i class="fas fa-image text-green-500 mr-2"></i>
                                    <span>Photo/Video</span>
                                </label>
                                @error('media')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-2 md:pt-[0px] mt-[20px]">
                                <button onclick="document.getElementById('myModal').classList.add('hidden')"
                                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                                    type="button">Cancel</button>
                                <button type="submit"
                                    class="bg-[#374697] hover:bg-[#374697d9] text-white px-4 py-1 rounded-md font-medium">
                                    Post update<i class="fas fa-paper-plane text-sm ml-1"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
