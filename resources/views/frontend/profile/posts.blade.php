<div class="space-y-6">
    @foreach ($posts as $post)
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" data-post-id="{{ $post->id }}">
            <!-- ... (previous post content) ... -->
            <!-- Post Header -->
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="@if (isset($currentProfileImage)) {{ Storage::url($currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
                        alt="User" class="w-10 h-10 rounded-full">
                    <div>
                        <h3 class="font-semibold">{{ $post->user->full_name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if ($user->id == Auth::id())
                <div class="relative dropdown-container">
                    <!-- Dropdown trigger button -->
                    <button class="rounded-[50%] bg-[#374697] hover:bg-[#374697d9] p-[12px] text-white profile-action-trigger">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <!-- Dropdown menu -->
                    <div
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200 dropdown-menu hidden">
                        {{-- <button class="flex items-center w-full px-4 py-2 text-sm text-blue-700 hover:bg-gray-100" onclick="openEditModal(this)" data-post-id="{{ $post->id }}"
    data-post-content="{{ $post->content }}" data-post-media="{{ $post->media_url }}">
                            <i class="fa-solid fa-pencil mr-1"></i>
                            Edit
                        </button> --}}
                        <a href="{{ route('delete-post',['postId' => $post->id]) }}" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fa-solid fa-trash mr-1"></i>
                            Delete
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Post Content -->
            <div class="px-4 pb-3">
                <p>{{ $post->content }}</p>
                {{-- Post Medie Code Start here --}}
                @if ($post->media_path)
                    @if ($post->media_type === 'image')
                        <img src="{{ $post->media_url }}" alt="Post image" class="mt-3 rounded-lg w-full">
                    @elseif($post->media_type === 'video')
                        <div class="video-container mt-3 rounded-lg w-full relative bg-black aspect-video">
                            <video class="w-full h-full object-contain" loop preload="metadata" playsinline>
                                <source src="{{ $post->media_url }}" type="video/mp4">
                            </video>

                            <div
                                class="video-controls absolute inset-0 flex flex-col justify-end opacity-0 transition-opacity duration-300">
                                <!-- Progress bar -->
                                <div class="w-full px-4 pt-2">
                                    <input type="range" class="w-full h-1 video-progress" value="0"
                                        min="0" max="100" step="0.1">
                                    <div class="flex justify-between text-white text-xs mt-1">
                                        <span class="current-time">0:00</span>
                                        <span class="duration">0:00</span>
                                    </div>
                                </div>

                                <!-- Bottom controls -->
                                <div class="bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <div class="flex items-center justify-between">
                                        <!-- Left controls -->
                                        <div class="flex items-center space-x-4">
                                            <button class="play-pause text-white text-xl">
                                                <i class="fas fa-play"></i>
                                            </button>

                                            <!-- Volume controls -->
                                            <div class="flex items-center space-x-2 group">
                                                <button class="volume-toggle text-white text-xl">
                                                    <i class="fas fa-volume-up"></i>
                                                </button>
                                                <input type="range"
                                                    class="volume-slider w-20 h-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                                    min="0" max="1" step="0.01" value="1">
                                            </div>
                                        </div>

                                        <!-- Right controls -->
                                        <div class="flex items-center space-x-3">
                                            <button class="fullscreen-toggle text-white text-xl">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                {{-- Post Medie Code End here --}}
            </div>
            <!-- Post Stats -->
            <div class="px-4 py-2 border-t border-b border-gray-100 flex justify-between text-sm text-gray-500">
                <div class="flex items-center space-x-1 reactions-summary" data-post-id="{{ $post->id }}">
                    @php
                        $reactionCounts = $post->reactions ? $post->reactions->getReactionCounts() : [];
                        $totalReactions = $post->reactions ? $post->reactions->getTotalReactions() : 0;
                        $displayedReactions = 0;
                    @endphp

                    @if ($totalReactions > 0)
                        @foreach ($reactionCounts as $type => $count)
                            @if ($count > 0 && $displayedReactions < 3)
                                <span class="reaction-emoji">{{ App\Models\PostReaction::$reactionTypes[$type] }}</span>
                                @php $displayedReactions++; @endphp
                            @endif
                        @endforeach
                        <span class="reaction-count text-sm text-gray-500">{{ $totalReactions }}</span>
                    @endif
                </div>
                <span class="comment-count" data-post-id="{{ $post->id }}">{{ $post->comments_count ?? 0 }}
                    comments</span>
            </div>
            <!-- Post Actions -->
            <div class="px-4 py-2 flex justify-between">
                <div class="reaction-container relative inline-block" data-post-id="{{ $post->id }}">
                    <button
                        class="like-btn flex items-center space-x-1 text-gray-500 hover:text-blue-500 focus:outline-none">
                        @php
                            $userReaction = null;
                            $reactionRecord = $post->reactions;

                            if ($reactionRecord) {
                                foreach ($reactionRecord->reactions as $type => $userIds) {
                                    if (in_array(auth()->id(), $userIds)) {
                                        $userReaction = $type;
                                        break;
                                    }
                                }
                            }

                            $reactionConfig = [
                                'like' => ['icon' => 'fas fa-thumbs-up', 'text' => 'Like'],
                                'love' => ['icon' => 'fas fa-heart', 'text' => 'Love'],
                                'haha' => ['icon' => 'far fa-laugh-squint', 'text' => 'Haha'],
                                'wow' => ['icon' => 'far fa-surprise', 'text' => 'Wow'],
                                'sad' => ['icon' => 'far fa-sad-tear', 'text' => 'Sad'],
                                'angry' => ['icon' => 'far fa-angry', 'text' => 'Angry'],
                            ];
                        @endphp

                        @if ($userReaction)
                            <i class="{{ $reactionConfig[$userReaction]['icon'] }}"></i>
                            <span>{{ $reactionConfig[$userReaction]['text'] }}</span>
                        @else
                            <i class="far fa-thumbs-up"></i>
                            <span>Like</span>
                        @endif
                    </button>
                    <!-- Emoji reaction picker -->
                    <div class="emoji-picker absolute bottom-full left-0 bg-white shadow-lg rounded-full p-2 hidden">
                        <div class="flex space-x-2">
                            @foreach ($reactions as $type => $emoji)
                                <span class="emoji-option hover:scale-125 transition-transform cursor-pointer text-xl"
                                    data-reaction="{{ $type }}" title="{{ ucfirst($type) }}">
                                    {{ $emoji }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reaction counts display -->
                    <div class="reactions-count ml-2 text-sm text-gray-500"></div>
                </div>
                <button
                    class="comment-toggle flex items-center space-x-1 text-gray-500 hover:text-green-500 focus:outline-none">
                    <i class="far fa-comment"></i>
                    <span>Comment</span>
                </button>
            </div>
            <!-- Inside your post loop, replace the comments section with this: -->
            <div class="comments-section hidden bg-gray-50 p-4 border-t border-gray-100">
                <!-- Existing Comments -->
                <div class="space-y-3 mb-4" id="comments-container-{{ $post->id }}">
                    @if (isset($post->comments))
                        @foreach ($post->comments as $comment)
                            <div class="comment flex space-x-2" data-comment-id="{{ $comment->id }}">
                                <img src="@if (isset($comment->user->currentProfileImage)) {{ Storage::url($comment->user->currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
                                    alt="User" class="w-8 h-8 rounded-full mt-1">
                                <div class="bg-white p-3 rounded-lg flex-1 relative">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-semibold text-sm">
                                            {{ $comment->user->full_name }}</h4>
                                        <span
                                            class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm mt-1 comment-content">
                                        {{ $comment->content }}</p>

                                    <!-- Comment actions (only show for comment owner) -->
                                    @if (auth()->id() === $comment->user_id)
                                        <div class="flex space-x-1 justify-end">
                                            <button class="edit-comment text-gray-500 hover:text-blue-500 text-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="delete-comment text-gray-500 hover:text-red-500 text-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Add Comment Form -->
                <div class="flex space-x-2">
                    <img src="@if (isset(Auth::user()->currentProfileImage->path)) {{ Storage::url(Auth::user()->currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
                        alt="User" class="w-8 h-8 rounded-full mt-1">
                    <div class="flex-1 flex">
                        <input type="text" placeholder="Write a comment..."
                            class="comment-input flex-1 text-sm px-3 py-2 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <button
                            class="comment-submit bg-blue-500 text-white px-3 py-2 rounded-r-lg hover:bg-blue-600 focus:outline-none"
                            data-post-id="{{ $post->id }}">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @if (count($posts) == 0)
        <h1 class="text-3xl font-bold flex justify-center">No Post Found</h1>
    @endif
</div>