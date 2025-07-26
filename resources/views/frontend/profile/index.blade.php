@extends('layouts.frontend')
<style>
    .video-container {
        position: relative;
        background-color: #000;
        overflow: hidden;
    }

    .video-container video {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .video-controls {
        transition: opacity 0.3s ease;
    }

    .video-controls:hover {
        opacity: 1 !important;
    }

    .video-progress,
    .volume-slider {
        -webkit-appearance: none;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
        cursor: pointer;
        outline: none;
    }

    .video-progress::-webkit-slider-thumb,
    .volume-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #fff;
        cursor: pointer;
    }

    .video-progress::-moz-range-thumb,
    .volume-slider::-moz-range-thumb {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #fff;
        cursor: pointer;
    }

    /* Hide controls when video is playing and no interaction */
    .video-container:not(:hover) .video-controls:not(.force-visible) {
        opacity: 0;
    }

    /* Show controls when paused or ended */
    .video-container video[data-state="paused"]+.video-controls,
    .video-container video[data-state="ended"]+.video-controls {
        opacity: 1;
    }


    .emoji-option {
        cursor: pointer;
        font-size: 1.5rem;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .emoji-picker {
        z-index: 100;
        transform: translateY(-10px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .emoji-picker.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
</style>
@section('title', 'On Track Eductaion - Profile')
@section('content')
    <div class="relative bg-white shadow-sm mb-4">
        <!-- Cover Photo Section with Always-Visible Upload Button -->
        <div class="h-64 bg-blue-500 w-full relative" id="coverPreview"
            style="background-size: cover; background-position: center; @if(isset($currentCoverImage)) background-image: url('{{ Storage::url($currentCoverImage->path) }}'); @endif">
            <!-- Improved button with full clickable area -->
            <label for="coverUpload" class="absolute bottom-4 right-4">
                <div
                    class="relative flex items-center bg-white bg-opacity-90 hover:bg-opacity-100 text-gray-800 px-3 py-1 rounded-md cursor-pointer transition-all shadow-md">
                    <i class="fas fa-camera mr-2 text-gray-700"></i>
                    <span class="text-sm font-medium">Update Cover</span>
                    <!-- Full-size invisible file input -->
                    <input type="file" id="coverUpload" accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewCoverImage(this)">
                </div>
            </label>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="flex flex-col md:flex-row items-center md:items-end -mt-16 pb-4">
                <!-- Profile Picture with Always-Visible Camera Icon -->
                <div class="relative">
                    <div class="w-32 h-32 rounded-full border-4 border-white bg-white overflow-hidden shadow-md">
                        <img id="profilePreview" src="@if(isset($currentProfileImage)) {{ Storage::url($currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif" alt="Profile"
                            class="w-full h-full object-cover">
                    </div>
                    <label for="profileUpload"
                        class="absolute -bottom-1 -right-1 bg-blue-500 hover:bg-blue-600 text-white rounded-full p-2 cursor-pointer shadow-md transition-transform hover:scale-110">
                        <i class="fas fa-camera text-sm"></i>
                        <input type="file" id="profileUpload" accept="image/*" class="hidden"
                            onchange="previewProfileImage(this)">
                    </label>
                </div>

                <div class="ml-0 md:ml-6 mt-4 md:mt-0 text-center md:text-left">
                    <h1 class="text-3xl font-bold">{{ $user->full_name }}</h1>
                </div>
                <div class="ml-auto mt-4 md:mt-0 flex space-x-2">
                    @if($user->id != Auth::id())
                        @if (auth()->user()->hasPendingFollowRequestFrom($user))
                            {{-- Show Accept/Decline buttons if someone requested to follow you --}}
                            <div class="flex space-x-2">
                                <button class="accept-follow bg-green-500 text-white px-4 py-2 rounded-md"
                                    data-user-id="{{ $user->id }}">
                                    Accept
                                </button>
                                <button class="decline-follow bg-red-500 text-white px-4 py-2 rounded-md"
                                    data-user-id="{{ $user->id }}">
                                    Decline
                                </button>
                            </div>
                        @elseif (auth()->user()->hasPendingFollowRequestTo($user))
                            <button class="follow-button bg-gray-200 text-black px-4 py-2 rounded-md"
                                data-user-id="{{ $user->id }}" data-state="requested">
                                Requested
                            </button>
                        @elseif (auth()->user()->isFollowing($user))
                            <button class="follow-button bg-gray-200 text-black px-4 py-2 rounded-md"
                                data-user-id="{{ $user->id }}" data-state="following">
                                Following
                            </button>
                        @else
                            <button class="follow-button bg-blue-500 text-white px-4 py-2 rounded-md"
                                data-user-id="{{ $user->id }}" data-state="follow">
                                {{ $user->isFollowing(auth()->user()) ? 'Follow Back' : 'Follow' }}
                            </button>
                        @endif
                    @endif
                    {{-- <button
                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-md font-medium flex items-center transition">
                        <i class="fas fa-pen mr-2"></i> Edit Profile
                    </button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Navigation -->
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <nav class="flex overflow-x-auto">
                <a href="#"
                    class="profile-tab-link px-6 py-4 border-b-4 whitespace-nowrap
          {{ !isset($parentTab) || $parentTab == 'posts-tab' ? 'border-blue-500 text-blue-500 font-medium' : 'border-transparent text-gray-600 hover:bg-gray-100' }}"
                    data-tab="posts-tab">Posts</a>
                <a href="#"
                    class="profile-tab-link px-6 py-4 border-b-4 whitespace-nowrap
          {{ isset($parentTab) && $parentTab == 'about-tab' ? 'border-blue-500 text-blue-500 font-medium' : 'border-transparent text-gray-600 hover:bg-gray-100' }}"
                    data-tab="about-tab">About</a>
                <a href="#" class="profile-tab-link px-6 py-4 text-gray-600 hover:bg-gray-100 whitespace-nowrap"
                    data-tab="friends-tab">Friends</a>
                <!-- <a href="#" class="profile-tab-link px-6 py-4 text-gray-600 hover:bg-gray-100 whitespace-nowrap"
                                                                    data-tab="photos-tab">Photos</a>
                                                                <a href="#" class="profile-tab-link px-6 py-4 text-gray-600 hover:bg-gray-100 whitespace-nowrap"
                                                    data-tab="videos-tab">Videos</a> -->
            </nav>
        </div>
    </div>
    <div class="container mx-auto px-4 md:mt-0 py-1">
        <div id="posts-tab"
            class="profile-tab-content {{ !isset($parentTab) || $parentTab == 'posts-tab' ? '' : 'hidden' }}">
            <div class="container mx-auto px-4 md:mt-0 py-6">
                <div class="flex flex-col md:flex-row gap-6 in-mobile-content">
                    <!-- Left Sidebar - Community -->
                    <aside
                        class="hidden md:block md:w-1/4 lg:w-1/5 bg-white rounded-lg shadow-md p-4 sticky top-20 self-start">
                        <h2 class="text-xl font-bold mb-4">Community</h2>
                        <nav class="space-y-2">
                            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                                    class="fas fa-home mr-2"></i>
                                Home</a>
                            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                                    class="fas fa-users mr-2"></i> My
                                Groups</a>
                            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                                    class="fas fa-comments mr-2"></i>
                                Discussions</a>
                            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                                    class="fas fa-calendar-alt mr-2"></i>
                                Events</a>
                            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                                    class="fas fa-book mr-2"></i>
                                Resources</a>
                            <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i
                                    class="fas fa-cog mr-2"></i>
                                Settings</a>
                        </nav>
                    </aside>

                    <!-- Main Content - Posts -->
                    <main class="flex-1 space-y-6">
                        <!-- Post Creation -->
                        @if ($user->id == Auth::id())
                            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar"
                                            class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                    </div>
                                    <div class="flex-1">
                                        <form action="{{ route('posts.store') }}" method="POST"
                                            enctype="multipart/form-data">
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
                                                    <input type="file" id="imageUpload" name="media"
                                                        accept="image/*,video/*" class="hidden"
                                                        onchange="previewImage(this)">
                                                    <label for="imageUpload"
                                                        class="flex items-center text-gray-500 hover:bg-gray-100 rounded-md px-3 py-1 cursor-pointer">
                                                        <i class="fas fa-image text-green-500 mr-2"></i>
                                                        <span>Photo/Video</span>
                                                    </label>
                                                    @error('media')
                                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-md font-medium">
                                                    Post
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="space-y-6">
                            @foreach ($posts as $post)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6"
                                    data-post-id="{{ $post->id }}">
                                    <!-- ... (previous post content) ... -->
                                    <!-- Post Header -->
                                    <div class="p-4 flex items-center space-x-3">
                                        <img src="{{ $post->user->image ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}"
                                            alt="User" class="w-10 h-10 rounded-full">
                                        <div>
                                            <h3 class="font-semibold">{{ $post->user->full_name }}</h3>
                                            <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <div class="px-4 pb-3">
                                        <p>{{ $post->content }}</p>
                                        {{-- Post Medie Code Start here --}}
                                        @if ($post->media_path)
                                            @if ($post->media_type === 'image')
                                                <img src="{{ $post->media_url }}" alt="Post image"
                                                    class="mt-3 rounded-lg w-full">
                                            @elseif($post->media_type === 'video')
                                                <div
                                                    class="video-container mt-3 rounded-lg w-full relative bg-black aspect-video">
                                                    <video class="w-full h-full object-contain" loop preload="metadata"
                                                        playsinline>
                                                        <source src="{{ $post->media_url }}" type="video/mp4">
                                                    </video>

                                                    <div
                                                        class="video-controls absolute inset-0 flex flex-col justify-end opacity-0 transition-opacity duration-300">
                                                        <!-- Progress bar -->
                                                        <div class="w-full px-4 pt-2">
                                                            <input type="range" class="w-full h-1 video-progress"
                                                                value="0" min="0" max="100"
                                                                step="0.1">
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
                                                                            min="0" max="1" step="0.01"
                                                                            value="1">
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
                                    <div
                                        class="px-4 py-2 border-t border-b border-gray-100 flex justify-between text-sm text-gray-500">
                                        <div class="flex items-center space-x-1 reactions-summary"
                                            data-post-id="{{ $post->id }}">
                                            @php
                                                $reactionCounts = $post->reactions
                                                    ? $post->reactions->getReactionCounts()
                                                    : [];
                                                $totalReactions = $post->reactions
                                                    ? $post->reactions->getTotalReactions()
                                                    : 0;
                                                $displayedReactions = 0;
                                            @endphp

                                            @if ($totalReactions > 0)
                                                @foreach ($reactionCounts as $type => $count)
                                                    @if ($count > 0 && $displayedReactions < 3)
                                                        <span
                                                            class="reaction-emoji">{{ App\Models\PostReaction::$reactionTypes[$type] }}</span>
                                                        @php $displayedReactions++; @endphp
                                                    @endif
                                                @endforeach
                                                <span
                                                    class="reaction-count text-sm text-gray-500">{{ $totalReactions }}</span>
                                            @endif
                                        </div>
                                        <span class="comment-count"
                                            data-post-id="{{ $post->id }}">{{ $post->comments_count ?? 0 }}
                                            comments</span>
                                    </div>
                                    <!-- Post Actions -->
                                    <div class="px-4 py-2 flex justify-between">
                                        <div class="reaction-container relative inline-block"
                                            data-post-id="{{ $post->id }}">
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
                                            <div
                                                class="emoji-picker absolute bottom-full left-0 bg-white shadow-lg rounded-full p-2 hidden">
                                                <div class="flex space-x-2">
                                                    @foreach ($reactions as $type => $emoji)
                                                        <span
                                                            class="emoji-option hover:scale-125 transition-transform cursor-pointer text-xl"
                                                            data-reaction="{{ $type }}"
                                                            title="{{ ucfirst($type) }}">
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
                                                    <div class="comment flex space-x-2"
                                                        data-comment-id="{{ $comment->id }}">
                                                        <img src="{{ $comment->user->image ?? 'https://randomuser.me/api/portraits/women/1.jpg' }}"
                                                            alt="User" class="w-8 h-8 rounded-full mt-1">
                                                        <div class="bg-white p-3 rounded-lg flex-1 relative">
                                                            <div class="flex justify-between items-start">
                                                                <h4 class="font-semibold text-sm">
                                                                    {{ $comment->user->full_name }}</h4>
                                                                <span
                                                                    class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="text-sm mt-1 comment-content">{{ $comment->content }}</p>

                                                            <!-- Comment actions (only show for comment owner) -->
                                                            @if (auth()->id() === $comment->user_id)
                                                                <div class="flex space-x-1 justify-end">
                                                                    <button
                                                                        class="edit-comment text-gray-500 hover:text-blue-500 text-sm">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button
                                                                        class="delete-comment text-gray-500 hover:text-red-500 text-sm">
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
                                            <img src="{{ auth()->user()->image ?? 'https://randomuser.me/api/portraits/men/3.jpg' }}"
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
                    </main>

                    <!-- Right Sidebar - Events -->
                    <aside class="hidden md:block md:w-1/4 lg:w-1/5 space-y-4 sticky top-20 self-start">
                        <!-- Events Card -->
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <h2 class="text-xl font-bold mb-4">Upcoming Events</h2>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3 p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fas fa-calendar-alt mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Group Meeting</h3>
                                        <p class="text-sm text-gray-600">Apr 28 - 18:00</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fas fa-calendar-alt mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Community Member</h3>
                                        <p class="text-sm text-gray-600">Apr 27 - 14:00</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-2 hover:bg-gray-50 rounded-lg transition">
                                    <i class="fas fa-calendar-alt mt-1"></i>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Workshop</h3>
                                        <p class="text-sm text-gray-600">May 1 - 10:35</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <h3 class="font-semibold mb-2">Recent Posts</h3>
                                <div class="space-y-2">
                                    <a href="#" class="block text-sm text-blue-500 hover:underline">ComSolar Benefit
                                        Issues...</a>
                                    <a href="#" class="block text-sm text-blue-500 hover:underline">Vote</a>
                                </div>
                            </div>
                        </div>

                        <!-- Second Card - New Card -->
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <!-- Heading -->
                            <h2 class="text-xl font-bold mb-4">Quick Access</h2>

                            <div class="space-y-4">
                                <!-- Announcement Card -->
                                <div class="flex gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                                    <div class="flex-shrink-0 mt-1 text-blue-500">
                                        <i class="fas fa-bullhorn text-lg"></i> <!-- Announcement icon -->
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Announcement</h3>
                                        <p class="text-sm text-gray-600 mt-1">Community guidelines updated - please
                                            review</p>
                                    </div>
                                </div>

                                <!-- Poll Card -->
                                <div class="flex gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                                    <div class="flex-shrink-0 mt-1 text-purple-500">
                                        <i class="fas fa-poll text-lg"></i> <!-- Poll icon -->
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Poll</h3>
                                        <p class="text-sm text-gray-600 mt-1">Should we host monthly meetups?</p>
                                        <button
                                            class="mt-2 text-sm bg-purple-500 hover:bg-purple-600 text-white py-1 px-3 rounded-md transition-colors">
                                            Vote Now
                                        </button>
                                    </div>
                                </div>

                                <!-- Suggestion Group Card -->
                                <div class="flex gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                                    <div class="flex-shrink-0 mt-1 text-green-500">
                                        <i class="fas fa-lightbulb text-lg"></i> <!-- Suggestion icon -->
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Suggestion Group</h3>
                                        <p class="text-sm text-gray-600 mt-1">Share your ideas for community improvement
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <div id="about-tab"
            class="profile-tab-content container mx-auto px-4 md:mt-0 py-6 pb-12 {{ isset($parentTab) && $parentTab == 'about-tab' ? '' : 'hidden' }}">
            <!-- Changed pb-4 to pb-12 -->
            <div class="flex flex-col md:flex-row gap-6 max-w-6xxl mx-auto">
                <!-- Left Sidebar - Vertical Tabs -->
                <div class="w-full md:w-1/4 lg:w-1/5 bg-white rounded-lg shadow-md p-4 self-start h-fit">
                    <h2 class="text-xl font-bold mb-4">About</h2>
                    <nav class="space-y-1" id="profileTabs">
                        <a href="#overview"
                            class="block px-4 py-2 rounded-md tab-link 
                            @if (!isset($tab)) bg-blue-50 text-blue-600 font-medium active @endif">Overview</a>
                        <a href="#work"
                            class="block px-4 py-2 rounded-md hover:bg-gray-100 tab-link 
                            @if (isset($tab) && $tab == 'work-education') bg-blue-50 text-blue-600 font-medium active @endif">Work
                            and
                            Education</a>
                        <a href="#places"
                            class="block px-4 py-2 rounded-md hover:bg-gray-100 tab-link
                            @if (isset($tab) && $tab == 'place-lived') bg-blue-50 text-blue-600 font-medium active @endif">Places
                            Lived</a>
                        <a href="#contact-info"
                            class="block px-4 py-2 rounded-md hover:bg-gray-100 tab-link 
                            @if (isset($tab) && $tab == 'contact-info') bg-blue-50 text-blue-600 font-medium active @endif">Contact
                            and
                            Basic Info</a>
                        <a href="#family"
                            class="block px-4 py-2 rounded-md hover:bg-gray-100 tab-link 
                            @if (isset($tab) && $tab == 'family-relationship') bg-blue-50 text-blue-600 font-medium active @endif">Family
                            and
                            Relationship</a>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="flex-1 bg-white rounded-lg shadow p-6 mb-12">
                    <!-- Overview Section -->
                    @include('frontend.profile.about.overview')

                    <!-- Work and Education Section -->
                    @include('frontend.profile.about.work-education')

                    <!-- Places Lived Section -->
                    @include('frontend.profile.about.places-lived')

                    <!-- Contact Details Section -->
                    @include('frontend.profile.about.contact-basic-info')

                    <!-- Family and Relationship Section -->
                    @include('frontend.profile.about.family-relationship')

                </div>
            </div>
        </div>

        <div id="friends-tab"
            class="profile-tab-content {{ isset($parentTab) && $parentTab == 'friends-tab' ? '' : 'hidden' }}">
            <div class="container mx-auto px-4 py-6">
                <!-- Simple Header -->
                <h1 class="text-2xl font-bold mb-6">Friends (1,245)</h1>

                <!-- Friends Grid - Simple Version -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <!-- Friend 1 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Friend"
                            class="w-full h-48 object-cover">
                        <div class="p-3">
                            <h3 class="font-semibold">John Doe</h3>
                            <p class="text-gray-500 text-sm">12 mutual friends</p>
                            <div class="flex mt-2 space-x-1">
                                <button
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-1 text-xs rounded">Message</button>
                                <button class="flex-1 bg-gray-200 hover:bg-gray-300 py-1 text-xs rounded">Remove</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friend Card 2 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Friend"
                            class="w-full h-48 object-cover">
                        <div class="p-3">
                            <h3 class="font-semibold">Sarah Smith</h3>
                            <p class="text-gray-500 text-sm">8 mutual friends</p>
                            <div class="flex mt-2 space-x-1">
                                <button
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-1 text-xs rounded">Message</button>
                                <button class="flex-1 bg-gray-200 hover:bg-gray-300 py-1 text-xs rounded">Remove</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friend Card 3 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <img src="https://randomuser.me/api/portraits/men/3.jpg" alt="Friend"
                            class="w-full h-48 object-cover">
                        <div class="p-3">
                            <h3 class="font-semibold">Mike Johnson</h3>
                            <p class="text-gray-500 text-sm">5 mutual friends</p>
                            <div class="flex mt-2 space-x-1">
                                <button
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-1 text-xs rounded">Message</button>
                                <button class="flex-1 bg-gray-200 hover:bg-gray-300 py-1 text-xs rounded">Remove</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friend Card 4 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Friend"
                            class="w-full h-48 object-cover">
                        <div class="p-3">
                            <h3 class="font-semibold">Emily Davis</h3>
                            <p class="text-gray-500 text-sm">3 mutual friends</p>
                            <div class="flex mt-2 space-x-1">
                                <button
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-1 text-xs rounded">Message</button>
                                <button class="flex-1 bg-gray-200 hover:bg-gray-300 py-1 text-xs rounded">Remove</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friend Card 5 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <img src="https://randomuser.me/api/portraits/men/5.jpg" alt="Friend"
                            class="w-full h-48 object-cover">
                        <div class="p-3">
                            <h3 class="font-semibold">David Wilson</h3>
                            <p class="text-gray-500 text-sm">15 mutual friends</p>
                            <div class="flex mt-2 space-x-1">
                                <button
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-1 text-xs rounded">Message</button>
                                <button class="flex-1 bg-gray-200 hover:bg-gray-300 py-1 text-xs rounded">Remove</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friend Card 6 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <img src="https://randomuser.me/api/portraits/women/6.jpg" alt="Friend"
                            class="w-full h-48 object-cover">
                        <div class="p-3">
                            <h3 class="font-semibold">Jessica Brown</h3>
                            <p class="text-gray-500 text-sm">7 mutual friends</p>
                            <div class="flex mt-2 space-x-1">
                                <button
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-1 text-xs rounded">Message</button>
                                <button class="flex-1 bg-gray-200 hover:bg-gray-300 py-1 text-xs rounded">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.profile-tab-link');
            const tabContents = document.querySelectorAll('.profile-tab-content');

            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all tabs
                    tabLinks.forEach(tab => {
                        tab.classList.remove('border-blue-500', 'text-blue-500',
                            'font-medium');
                        tab.classList.add('text-gray-600', 'hover:bg-gray-100');
                    });

                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.add('hidden'));

                    // Add active class to clicked tab
                    this.classList.remove('text-gray-600', 'hover:bg-gray-100');
                    this.classList.add('border-blue-500', 'text-blue-500', 'font-medium');

                    // Show corresponding content
                    const target = this.getAttribute('data-tab');
                    document.getElementById(target).classList.remove('hidden');
                });
            });

            // Initialize the first tab as active
            // const firstTab = document.querySelector('.profile-tab-link');
            // if (firstTab) firstTab.click();
        });

        function previewImage(input) {
            const previewContainer = document.querySelector('.image-preview-container');
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }

                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            const previewContainer = document.querySelector('.image-preview-container');
            previewContainer.style.display = 'none';
            document.getElementById('imageUpload').value = '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Toggle comments section
            document.querySelectorAll('.comment-toggle').forEach(button => {
                button.addEventListener('click', function() {
                    const commentsSection = this.closest('.bg-white').querySelector(
                        '.comments-section');
                    commentsSection.classList.toggle('hidden');
                });
            });
        });
        function uploadMedia(file, type) {
            const formData = new FormData();
            formData.append('media', file);
            formData.append('type', type);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            return fetch('/media/upload', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json());
        }
        function previewCoverImage(input) {
            if (input.files && input.files[0]) {
                const preview = document.getElementById('coverPreview');
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    uploadMedia(input.files[0], 'cover')
                        .then(data => {
                            if (data.success) {
                                toastr.success('Cover image updated!');
                            }
                        });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        

        function previewProfileImage(input) {

            if (input.files && input.files[0]) {
                const preview = document.getElementById('profilePreview');
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    uploadMedia(input.files[0], 'profile')
                        .then(data => {
                            if (data.success) {
                                toastr.success('Profile image updated!');
                            }
                        });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all follow-related buttons
            initFollowButtons();

            function initFollowButtons() {
                // Handle main follow button states
                document.querySelectorAll('.follow-button').forEach(button => {
                    button.addEventListener('click', function(e) {
                        handleFollowAction(e, this);
                    });
                });

                // Handle accept follow request
                document.querySelectorAll('.accept-follow').forEach(button => {
                    button.addEventListener('click', function(e) {
                        handleFollowRequestAction(e, this, 'accept');
                    });
                });

                // Handle decline follow request
                document.querySelectorAll('.decline-follow').forEach(button => {
                    button.addEventListener('click', function(e) {
                        handleFollowRequestAction(e, this, 'decline');
                    });
                });
            }

            function handleFollowAction(e, button) {
                e.preventDefault();

                const userId = button.getAttribute('data-user-id');
                const currentState = button.getAttribute('data-state');
                let url = `/users/${userId}/follow`;

                // Determine endpoint based on current state
                switch (currentState) {
                    case 'following':
                        url = `/users/${userId}/unfollow`;
                        break;
                    case 'requested':
                        url = `/users/${userId}/follow/cancel`;
                        break;
                    case 'pending':
                        url = `/users/${userId}/follow/accept`;
                        break;
                }

                sendFollowRequest(button, url);
            }

            function handleFollowRequestAction(e, button, action) {
                e.preventDefault();
                const userId = button.getAttribute('data-user-id');
                const url = `/users/${userId}/follow/${action}`;

                // Get the parent container to replace with new state
                const container = button.closest('.flex.space-x-2');
                sendFollowRequest(button, url, true, container);
            }

            function sendFollowRequest(button, url, shouldReload = false, container = null) {
                // Save original state
                const originalHTML = button.innerHTML;
                const originalState = button.getAttribute('data-state') || '';

                // Show loading state
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            showAlert('error', data.error);
                            return;
                        }

                        if (shouldReload) {
                            window.location.reload();
                        } else if (container) {
                            // Replace accept/decline buttons with follow state
                            updateContainerAfterResponse(container, data);
                        } else {
                            updateButtonState(button, data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'An error occurred. Please try again.');
                    })
                    .finally(() => {
                        if (!shouldReload && !container) {
                            button.disabled = false;
                            if (!button.hasAttribute('data-updated')) {
                                button.innerHTML = originalHTML;
                            }
                            button.removeAttribute('data-updated');
                        }
                    });
            }

            function updateContainerAfterResponse(container, data) {
                // Create new follow button based on response
                const newButton = document.createElement('button');
                newButton.className = 'follow-button bg-gray-200 text-black px-4 py-2 rounded-md';
                newButton.setAttribute('data-user-id', container.querySelector('button').getAttribute(
                    'data-user-id'));

                if (data.following) {
                    newButton.innerHTML = 'Following';
                    newButton.setAttribute('data-state', 'following');
                } else {
                    newButton.innerHTML = 'Follow';
                    newButton.setAttribute('data-state', 'follow');
                }

                // Replace the container with the new button
                container.parentNode.replaceChild(newButton, container);

                // Re-initialize event listeners
                newButton.addEventListener('click', function(e) {
                    handleFollowAction(e, this);
                });
            }

            function updateButtonState(button, data) {
                const stateClasses = {
                    'follow': ['bg-blue-500', 'text-white'],
                    'following': ['bg-gray-200', 'text-black'],
                    'requested': ['bg-yellow-500', 'text-white'],
                    'mutual': ['bg-green-500', 'text-white']
                };

                // Remove all state classes first
                Object.values(stateClasses).flat().forEach(cls => {
                    button.classList.remove(cls);
                });

                // Set new state
                if (data.status === 'pending' || data.status === 'requested') {
                    button.innerHTML = 'Requested';
                    button.setAttribute('data-state', 'requested');
                    button.classList.add(...stateClasses['requested']);
                } else if (data.mutual) {
                    button.innerHTML = 'Friends';
                    button.setAttribute('data-state', 'mutual');
                    button.classList.add(...stateClasses['mutual']);
                } else if (data.following) {
                    button.innerHTML = 'Following';
                    button.setAttribute('data-state', 'following');
                    button.classList.add(...stateClasses['following']);
                } else {
                    const followBack = button.getAttribute('data-follow-back') === 'true';
                    button.innerHTML = followBack ? 'Follow Back' : 'Follow';
                    button.setAttribute('data-state', 'follow');
                    button.classList.add(...stateClasses['follow']);
                }

                button.setAttribute('data-updated', 'true');
            }

            function showAlert(type, message) {
                // Replace with your preferred notification system
                alert(message);
            }
        });


        // Video controls functionality
        class VideoPlayer {
            constructor(container) {
                this.container = container;
                this.video = container.querySelector('video');
                this.controls = container.querySelector('.video-controls');
                this.playBtn = container.querySelector('.play-pause');
                this.volumeBtn = container.querySelector('.volume-toggle');
                this.volumeSlider = container.querySelector('.volume-slider');
                this.progressBar = container.querySelector('.video-progress');
                this.currentTimeDisplay = container.querySelector('.current-time');
                this.durationDisplay = container.querySelector('.duration');

                this.userInteracted = false;
                this.isHovered = false;

                this.init();
            }

            init() {
                // Set initial volume state
                this.video.volume = 1;
                this.video.muted = false;

                // Event listeners
                this.video.addEventListener('loadedmetadata', this.updateDuration.bind(this));
                this.video.addEventListener('timeupdate', this.updateProgress.bind(this));
                this.video.addEventListener('click', this.togglePlay.bind(this));
                this.video.addEventListener('ended', this.handleEnded.bind(this));

                this.playBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.togglePlay();
                });

                this.volumeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleMute();
                });

                if (this.volumeSlider) {
                    this.volumeSlider.addEventListener('input', (e) => {
                        e.stopPropagation();
                        this.setVolume(e.target.value);
                    });
                }

                this.progressBar.addEventListener('input', (e) => {
                    this.seekVideo(e.target.value);
                });

                this.container.querySelector('.fullscreen-toggle').addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleFullscreen();
                });
            }

            formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);
                return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
            }

            updateDuration() {
                this.durationDisplay.textContent = this.formatTime(this.video.duration);
            }

            updateProgress() {
                const percent = (this.video.currentTime / this.video.duration) * 100;
                this.progressBar.value = percent;
                this.currentTimeDisplay.textContent = this.formatTime(this.video.currentTime);
            }

            togglePlay() {
                this.userInteracted = true;

                if (this.video.paused) {
                    this.video.play()
                        .then(() => {
                            this.playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                            this.video.muted = false;
                            this.volumeBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
                            if (this.volumeSlider) {
                                this.volumeSlider.value = this.video.volume;
                            }
                        })
                        .catch(e => console.error("Play failed:", e));
                } else {
                    this.video.pause();
                    this.playBtn.innerHTML = '<i class="fas fa-play"></i>';
                }
            }

            toggleMute() {
                this.userInteracted = true;
                this.video.muted = !this.video.muted;
                this.volumeBtn.innerHTML = this.video.muted ?
                    '<i class="fas fa-volume-mute"></i>' :
                    '<i class="fas fa-volume-up"></i>';

                if (this.volumeSlider) {
                    this.volumeSlider.value = this.video.muted ? 0 : this.video.volume;
                }
            }

            setVolume(volume) {
                this.userInteracted = true;
                this.video.volume = volume;
                this.video.muted = volume == 0;
                this.volumeBtn.innerHTML = volume == 0 ?
                    '<i class="fas fa-volume-mute"></i>' :
                    '<i class="fas fa-volume-up"></i>';
            }

            seekVideo(percent) {
                const seekTime = (percent / 100) * this.video.duration;
                this.video.currentTime = seekTime;
            }

            toggleFullscreen() {
                if (!document.fullscreenElement) {
                    this.container.requestFullscreen().catch(err => {
                        console.log(`Fullscreen error: ${err.message}`);
                    });
                } else {
                    document.exitFullscreen();
                }
            }

            handleEnded() {
                this.playBtn.innerHTML = '<i class="fas fa-redo"></i>';
            }
        }

        // Initialize all video players when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.video-container').forEach(container => {
                new VideoPlayer(container);
            });
        });

        // Comment Code start here

        document.addEventListener('DOMContentLoaded', function() {
            // CSRF token setup
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function updateCommentCount(postId, change) {
                const commentCountElement = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
                if (commentCountElement) {
                    const currentCount = parseInt(commentCountElement.textContent) || 0;
                    const newCount = Math.max(0, currentCount + change);
                    commentCountElement.textContent = `${newCount} comment${newCount !== 1 ? 's' : ''}`;
                }
            }
            // Add comment
            document.querySelectorAll('.comment-submit').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const input = this.parentElement.querySelector('.comment-input');
                    const content = input.value.trim();

                    if (!content) return;

                    fetch(`/posts/${postId}/comments`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                content: content
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                input.value = '';
                                const commentsContainer = document.querySelector(
                                    `#comments-container-${postId}`);

                                const commentHtml = `
                    <div class="comment flex space-x-2" data-comment-id="${data.comment.id}">
                        <img src="${data.comment.user.image || 'https://randomuser.me/api/portraits/women/1.jpg'}" 
                            alt="User" class="w-8 h-8 rounded-full mt-1">
                        <div class="bg-white p-3 rounded-lg flex-1 relative">
                            <div class="flex justify-between items-start">
                                <h4 class="font-semibold text-sm">${data.comment.user.full_name}</h4>
                                <span class="text-xs text-gray-400">Just now</span>
                            </div>
                            <p class="text-sm mt-1 comment-content">${data.comment.content}</p>
                            <div class="flex space-x-1 justify-end">
                                <button class="edit-comment text-gray-500 hover:text-blue-500 text-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="delete-comment text-gray-500 hover:text-red-500 text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                                commentsContainer.insertAdjacentHTML('beforeend', commentHtml);
                                initCommentActions(commentsContainer.lastElementChild);
                                updateCommentCount(postId, 1);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            // Edit comment
            function setupEditComment(commentElement) {
                const editBtn = commentElement.querySelector('.edit-comment');
                const contentElement = commentElement.querySelector('.comment-content');
                if (!editBtn || !contentElement) return;

                const originalContent = contentElement.textContent;

                editBtn.addEventListener('click', function() {
                    // Replace content with textarea
                    const textarea = document.createElement('textarea');
                    textarea.className = 'w-full p-2 border rounded';
                    textarea.value = originalContent;

                    // Create save/cancel buttons
                    const buttonContainer = document.createElement('div');
                    buttonContainer.className = 'flex space-x-2 mt-2';

                    const saveBtn = document.createElement('button');
                    saveBtn.className = 'bg-blue-500 text-white px-2 py-1 rounded text-xs';
                    saveBtn.textContent = 'Save';

                    const cancelBtn = document.createElement('button');
                    cancelBtn.className = 'bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs';
                    cancelBtn.textContent = 'Cancel';

                    // Replace content with edit form
                    contentElement.replaceWith(textarea);
                    textarea.after(buttonContainer);
                    buttonContainer.append(saveBtn, cancelBtn);

                    // Save handler
                    saveBtn.addEventListener('click', function() {
                        const newContent = textarea.value.trim();
                        if (!newContent) return;

                        const commentId = commentElement.getAttribute('data-comment-id');

                        fetch(`/comments/${commentId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    content: newContent
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Restore content display
                                    contentElement.textContent = data.comment.content;
                                    textarea.replaceWith(contentElement);
                                    buttonContainer.remove();
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    });

                    // Cancel handler
                    cancelBtn.addEventListener('click', function() {
                        textarea.replaceWith(contentElement);
                        buttonContainer.remove();
                    });
                });
            }

            // Delete comment
            function setupDeleteComment(commentElement) {
                const deleteBtn = commentElement.querySelector('.delete-comment');
                if (!deleteBtn) return;
                deleteBtn.addEventListener('click', function() {
                    if (!confirm('Are you sure you want to delete this comment?')) return;

                    const commentId = commentElement.getAttribute('data-comment-id');
                    const postId = commentElement.closest('[data-post-id]').getAttribute('data-post-id');
                    fetch(`/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                commentElement.remove();
                                updateCommentCount(postId, -1);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }

            // Initialize comment actions for existing comments
            function initCommentActions(commentElement) {
                setupEditComment(commentElement);
                setupDeleteComment(commentElement);
            }

            // Initialize actions for all existing comments
            document.querySelectorAll('.comment').forEach(comment => {
                initCommentActions(comment);
            });

            // Also allow submitting comments with Enter key
            document.querySelectorAll('.comment-input').forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.parentElement.querySelector('.comment-submit').click();
                    }
                });
            });
        });

        // Like and Dislike Code Start Here

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all reaction containers
            document.querySelectorAll('.reaction-container').forEach(container => {
                const postId = container.dataset.postId;
                const likeBtn = container.querySelector('.like-btn');
                const emojiPicker = container.querySelector('.emoji-picker');
                let reactionTimeout;

                // Initialize currentReaction based on the button's current icon
                let currentReaction = null;
                const icon = likeBtn.querySelector('i');
                const reactionClasses = Array.from(icon.classList);

                // Check which reaction is active by comparing against possible reaction icons
                if (reactionClasses.includes('fa-thumbs-up') && !reactionClasses.includes('far')) {
                    currentReaction = 'like';
                } else if (reactionClasses.includes('fa-heart')) {
                    currentReaction = 'love';
                } else if (reactionClasses.includes('fa-laugh-squint')) {
                    currentReaction = 'haha';
                } else if (reactionClasses.includes('fa-surprise')) {
                    currentReaction = 'wow';
                } else if (reactionClasses.includes('fa-sad-tear')) {
                    currentReaction = 'sad';
                } else if (reactionClasses.includes('fa-angry')) {
                    currentReaction = 'angry';
                }

                // Show emoji picker on hover
                likeBtn.addEventListener('mouseenter', () => {
                    reactionTimeout = setTimeout(() => {
                        emojiPicker.classList.remove('hidden');
                        emojiPicker.classList.add('show');
                    }, 200);
                });

                // Hide emoji picker when leaving like button
                likeBtn.addEventListener('mouseleave', () => {
                    clearTimeout(reactionTimeout);
                    setTimeout(() => {
                        if (!emojiPicker.matches(':hover')) {
                            hidePicker();
                        }
                    }, 2000);
                });

                // Keep picker open when hovering over it
                emojiPicker.addEventListener('mouseenter', () => {
                    clearTimeout(reactionTimeout);
                    emojiPicker.classList.add('show');
                });

                emojiPicker.addEventListener('mouseleave', hidePicker);

                // Handle main button click - remove reaction if exists
                likeBtn.addEventListener('click', (e) => {
                    // Only handle if not clicking an emoji option
                    if (!e.target.closest('.emoji-option')) {
                        if (currentReaction) {
                            sendReaction(postId, currentReaction, true);
                            currentReaction = null;
                            hidePicker();
                            e.preventDefault();
                            e.stopPropagation();
                        }
                    }
                });

                // Handle emoji selection
                emojiPicker.querySelectorAll('.emoji-option').forEach(emoji => {
                    emoji.addEventListener('click', () => {
                        const reaction = emoji.dataset.reaction;
                        if (currentReaction === reaction) {
                            // If clicking the same reaction, remove it
                            sendReaction(postId, reaction, true);
                            currentReaction = null;
                        } else {
                            // If clicking a different reaction, send the new one
                            sendReaction(postId, reaction);
                            currentReaction = reaction;
                        }
                        hidePicker();
                    });
                });

                function hidePicker() {
                    emojiPicker.classList.remove('show');
                    setTimeout(() => {
                        if (!emojiPicker.matches(':hover')) {
                            emojiPicker.classList.add('hidden');
                        }
                    }, 2000);
                }

                function sendReaction(postId, reaction, remove = false) {
                    const token = document.querySelector('meta[name="csrf-token"]').content;

                    const validReactions = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];

                    if (!validReactions.includes(reaction)) {
                        console.error('Invalid reaction type:', reaction);
                        return;
                    }
                    fetch(`/posts/${postId}/react`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                reaction,
                                remove: remove || false
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateReactionButton(postId, data);
                                updateReactionSummary(postId, data.reaction_counts, data
                                    .total_reactions);
                                if (data.action === 'removed') {
                                    currentReaction = null;
                                }
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function updateReactionSummary(postId, reactionsCount, totalReactions) {
                    const summaryElement = document.querySelector(
                        `.reactions-summary[data-post-id="${postId}"]`);
                    if (!summaryElement) return;

                    const reactionEmojis = {
                        'like': '👍',
                        'love': '❤️',
                        'haha': '😆',
                        'wow': '😮',
                        'sad': '😢',
                        'angry': '😡'
                    };

                    if (totalReactions > 0) {
                        let html = '';
                        let displayed = 0;

                        // Create array of reaction types with counts
                        const reactionsArray = Object.entries(reactionsCount)
                            .filter(([_, count]) => count > 0)
                            .sort((a, b) => b[1] - a[1]);

                        // Display top 3 reactions
                        for (const [type, count] of reactionsArray) {
                            if (displayed < 3) {
                                html += `<span class="reaction-emoji">${reactionEmojis[type]}</span>`;
                                displayed++;
                            }
                        }

                        html +=
                            `<span class="reaction-count text-sm text-gray-500">${totalReactions}</span>`;
                        summaryElement.innerHTML = html;
                    } else {
                        summaryElement.innerHTML = '';
                    }
                }

                function updateReactionButton(postId, response) {
                    const container = document.querySelector(
                        `.reaction-container[data-post-id="${postId}"]`);
                    if (!container) return;

                    const likeBtn = container.querySelector('.like-btn');
                    if (!likeBtn) return;

                    const icon = likeBtn.querySelector('i');
                    const text = likeBtn.querySelector('span');

                    const reactionConfig = {
                        like: {
                            class: 'fas fa-thumbs-up',
                            text: 'Like'
                        },
                        love: {
                            class: 'fas fa-heart',
                            text: 'Love'
                        },
                        haha: {
                            class: 'far fa-laugh-squint',
                            text: 'Haha'
                        },
                        wow: {
                            class: 'far fa-surprise',
                            text: 'Wow'
                        },
                        sad: {
                            class: 'far fa-sad-tear',
                            text: 'Sad'
                        },
                        angry: {
                            class: 'far fa-angry',
                            text: 'Angry'
                        }
                    };

                    if (response.action === 'removed') {
                        icon.className = 'far fa-thumbs-up';
                        text.textContent = 'Like';
                        currentReaction = null;
                    } else if (reactionConfig[response.reaction]) {
                        icon.className = reactionConfig[response.reaction].class;
                        text.textContent = reactionConfig[response.reaction].text;
                        currentReaction = response.reaction;
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching code (existing)
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');

            const activeTabLink = document.querySelector('.tab-link.active');
            if (activeTabLink) {
                const activeContent = document.querySelector(activeTabLink.getAttribute('href'));
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                }
            }

            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    tabLinks.forEach(tab => tab.classList.remove('active', 'bg-blue-50',
                        'text-blue-600'));
                    tabContents.forEach(content => content.classList.add('hidden'));

                    this.classList.add('active', 'bg-blue-50', 'text-blue-600');
                    document.querySelector(this.getAttribute('href')).classList.remove('hidden');
                });
            });

            // New code for form toggling
            const workSection = document.querySelector('#work');

            // More specific selectors for the buttons
            const addWorkBtn = document.getElementById('addWorkBtn');
            const addSchoolBtn = document.getElementById('addSchoolBtn');

            const workForm = document.getElementById('work-form');
            const educationForm = document.getElementById('education-form');

            // For "Add workplace" button
            if (addWorkBtn) {
                addWorkBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    workForm.classList.toggle('hidden');
                    // Hide education form if open
                    educationForm.classList.add('hidden');
                });
            } else {
                console.error("Could not find 'Add workplace' button");
            }

            // For "Add school" button
            if (addSchoolBtn) {
                addSchoolBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    educationForm.classList.toggle('hidden');
                    // Hide work form if open
                    workForm.classList.add('hidden');
                });
            } else {
                console.error("Could not find 'Add school' button");
            }

            // For cancel buttons - more specific selector
            document.querySelectorAll('#work-form button:first-child, #education-form button:first-child').forEach(
                btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        workForm.classList.add('hidden');
                        educationForm.classList.add('hidden');
                    });
                });
        });
        // Places Lived Section Functionality
        const addCurrentCityBtn = document.getElementById('addCurrentCityBtn');
        const addHometownBtn = document.getElementById('addHometownBtn');
        const addOtherPlaceBtn = document.getElementById('addOtherPlaceBtn');

        const currentCityForm = document.getElementById('current-city-form');
        const hometownForm = document.getElementById('hometown-form');
        const otherPlaceForm = document.getElementById('other-place-form');

        // Current City
        if (addCurrentCityBtn) {
            addCurrentCityBtn.addEventListener('click', function(e) {
                e.preventDefault();
                currentCityForm.classList.toggle('hidden');
                // Hide other forms
                hometownForm.classList.add('hidden');
                otherPlaceForm.classList.add('hidden');
            });
        }

        // Hometown
        if (addHometownBtn) {
            addHometownBtn.addEventListener('click', function(e) {
                e.preventDefault();
                hometownForm.classList.toggle('hidden');
                // Hide other forms
                currentCityForm.classList.add('hidden');
                otherPlaceForm.classList.add('hidden');
            });
        }

        // Other Places
        if (addOtherPlaceBtn) {
            addOtherPlaceBtn.addEventListener('click', function(e) {
                e.preventDefault();
                otherPlaceForm.classList.toggle('hidden');
                // Hide other forms
                currentCityForm.classList.add('hidden');
                hometownForm.classList.add('hidden');
            });
        }

        // Cancel buttons for places forms
        document.querySelectorAll('.cancel-places-form').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                currentCityForm.classList.add('hidden');
                hometownForm.classList.add('hidden');
                otherPlaceForm.classList.add('hidden');
            });
        });



        // Contact and Basic Info Section Functionality
        const addContactBtn = document.getElementById('addContactBtn');
        const editBasicInfoBtn = document.getElementById('editBasicInfoBtn');

        const contactForm = document.getElementById('contact-form');
        const basicInfoForm = document.getElementById('basic-info-form');

        // Contact Information
        if (addContactBtn) {
            addContactBtn.addEventListener('click', function(e) {
                e.preventDefault();
                contactForm.classList.toggle('hidden');
                // Hide basic info form if open
                basicInfoForm.classList.add('hidden');
            });
        }

        // Basic Information
        if (editBasicInfoBtn) {
            editBasicInfoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                basicInfoForm.classList.toggle('hidden');
                // Hide contact form if open
                contactForm.classList.add('hidden');
            });
        }

        // Cancel buttons
        document.querySelectorAll('.cancel-contact-form').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                contactForm.classList.add('hidden');
            });
        });

        document.querySelectorAll('.cancel-basic-info-form').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                basicInfoForm.classList.add('hidden');
            });
        });

        // Languages functionality
        const languagesForm = document.getElementById('languages-form');
        const languageInput = document.getElementById('language-input');
        const addLanguageBtn = document.getElementById('add-language-btn');
        const languageTagsContainer = document.getElementById('language-tags-container');
        const languagesContainer = document.getElementById('languages-container');
        const saveLanguagesBtn = document.getElementById('save-languages-btn');
        const languageInputsContainer = document.getElementById('language-inputs-container');

        // Sample initial languages
        let languages = [];

        @if ($basicInfo->languages && count($basicInfo->languages) > 0)
            languages = {!! json_encode($basicInfo->languages) !!};
        @endif
        if (languagesContainer) {
            displayLanguages();
        }

        if (languageTagsContainer) {
            displayLanguageTags();
        }
        // Display languages in view mode
        function displayLanguages() {
            if (!languagesContainer) return;
            languagesContainer.innerHTML = '';
            languages.forEach(language => {
                const tag = document.createElement('span');
                tag.className =
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                tag.textContent = language;
                languagesContainer.appendChild(tag);
            });
        }
        displayLanguageTags();
        // Display languages in edit mode
        function displayLanguageTags() {
            if (!languageTagsContainer) return;
            languageTagsContainer.innerHTML = '';
            languages.forEach(language => {
                const tag = document.createElement('span');
                tag.className =
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                tag.innerHTML = `${language} <button type="button" class="ml-1 text-blue-500 hover:text-blue-700 remove-language" data-lang="${language}">
                        <i class="fas fa-times"></i>
                     </button>`;
                languageTagsContainer.appendChild(tag);
            });
            document.querySelectorAll('.remove-language').forEach(btn => {
                btn.addEventListener('click', function() {
                    const langToRemove = this.getAttribute('data-lang');
                    removeLanguage(langToRemove);
                });
            });
            // Update hidden inputs for form submission
            syncLanguageInputs();
        }

        function removeLanguage(language) {
            languages = languages.filter(lang => lang !== language);
            displayLanguageTags();
            if (languagesContainer) displayLanguages();
        }
        // Sync languages with hidden form inputs
        function syncLanguageInputs() {
            if (!languageInputsContainer) return;
            languageInputsContainer.innerHTML = '';
            languages.forEach(language => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'languages[]';
                input.value = language;
                languageInputsContainer.appendChild(input);
            });
        }


        // Add Language Button
        if (addLanguageBtn) {
            addLanguageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const newLanguage = languageInput.value.trim();
                if (newLanguage && !languages.includes(newLanguage)) {
                    languages.push(newLanguage);
                    languageInput.value = '';
                    displayLanguageTags();
                }
            });

            // Also allow adding with Enter key
            languageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addLanguageBtn.click();
                }
            });
        }

        // Save Languages Button
        if (saveLanguagesBtn) {
            saveLanguagesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                displayLanguages();
                languagesForm.classList.add('hidden');
            });
        }

        // Cancel button
        document.querySelectorAll('.cancel-languages-form').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                languagesForm.classList.add('hidden');
                // Restore original languages if canceled
                displayLanguages();
            });
        });

        // Initialize languages display
        displayLanguages();



        // Family and Relationships functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Relationship Status
            const editRelationshipBtn = document.getElementById('editRelationshipBtn');
            const relationshipForm = document.getElementById('relationship-form');
            const relationshipDisplay = document.getElementById('relationship-display');
            const relationshipStatus = document.getElementById('relationship-status');
            const partnerNameContainer = document.getElementById('partner-name-container');
            const partnerName = document.getElementById('partner-name');
            const anniversaryContainer = document.getElementById('anniversary-container');
            const saveRelationshipBtn = document.getElementById('save-relationship-btn');

            // Family Members
            const addFamilyMemberBtn = document.getElementById('addFamilyMemberBtn');
            const familyMemberForm = document.getElementById('family-member-form');
            const familyMembersContainer = document.getElementById('family-members-container');
            const familyMemberName = document.getElementById('family-member-name');
            const familyRelationship = document.getElementById('family-relationship');
            const customRelationshipContainer = document.getElementById('custom-relationship-container');
            const customRelationship = document.getElementById('custom-relationship');
            const saveFamilyMemberBtn = document.getElementById('save-family-member-btn');

            // Current data
            let relationshipData = {
                status: '',
                partner: '',
                anniversary: ''
            };

            let familyMembers = [];

            // Show/hide partner fields based on relationship status
            const relationshipStatusesWithPartner = @json(config('relationship.statuses_with_partner'));

            relationshipStatus.addEventListener('change', function() {
                const status = this.value;
                // partnerNameContainer.classList.toggle('hidden', !relationshipStatusesWithPartner.includes(
                //     status));
                // anniversaryContainer.classList.toggle('hidden', !relationshipStatusesWithPartner.includes(
                //     status));


                const shouldShowPartnerFields = relationshipStatusesWithPartner.includes(status);

                // Toggle visibility
                partnerNameContainer.classList.toggle('hidden', !shouldShowPartnerFields);
                anniversaryContainer.classList.toggle('hidden', !shouldShowPartnerFields);

                // Clear values if hiding the fields
                if (!shouldShowPartnerFields) {
                    document.getElementById('friend-search').value = '';
                    document.getElementById('user-id-input').value = '';
                    document.getElementById('anniversary_date').value = '';
                }
            });

            // Show/hide custom relationship field
            familyRelationship.addEventListener('change', function() {
                customRelationshipContainer.classList.toggle('hidden', this.value !== 'Other');
            });

            // Edit Relationship Button
            if (editRelationshipBtn) {
                editRelationshipBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    relationshipForm.classList.remove('hidden');
                });
            }

            // Add Family Member Button
            if (addFamilyMemberBtn) {
                addFamilyMemberBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    familyMemberForm.classList.remove('hidden');
                });
            }

            // Edit family member
            function editFamilyMember(index) {
                const member = familyMembers[index];
                familyMemberName.value = member.name;

                // Check if relationship is in the standard options
                const standardRelationships = Array.from(familyRelationship.options).map(opt => opt.value);
                if (standardRelationships.includes(member.relationship)) {
                    familyRelationship.value = member.relationship;
                    customRelationshipContainer.classList.add('hidden');
                } else {
                    familyRelationship.value = 'Other';
                    customRelationship.value = member.relationship;
                    customRelationshipContainer.classList.remove('hidden');
                }

                familyMemberForm.classList.remove('hidden');
            }

            // Cancel buttons
            document.querySelectorAll('.cancel-relationship-form').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    relationshipForm.classList.add('hidden');
                });
            });

            document.querySelectorAll('.cancel-family-member-form').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    familyMemberForm.classList.add('hidden');
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle the to_year field visibility and state
            function handlePresentCheckbox(checkbox) {
                const form = checkbox.closest('form');
                if (!form) return; // Exit if no form found

                const toYearSelect = form.querySelector('select[name="to_year"]');
                const toYearContainer = form.querySelector('.to-year-container');
                const toYearLabel = form.querySelector('.to-year-container label');

                // Exit if required elements aren't found
                if (!toYearSelect || !toYearContainer || !toYearLabel) return;

                if (checkbox.checked) {
                    // Hide and disable the to_year field
                    toYearSelect.disabled = true;
                    toYearSelect.value = '';
                    toYearContainer.style.opacity = '0.5';
                    toYearLabel.style.opacity = '0.5';

                    // Add visual indication that the field is disabled
                    toYearSelect.classList.add('bg-gray-100');
                    toYearSelect.classList.remove('focus:ring-blue-500');
                } else {
                    // Show and enable the to_year field
                    toYearSelect.disabled = false;
                    toYearContainer.style.opacity = '1';
                    toYearLabel.style.opacity = '1';

                    // Remove visual indication
                    toYearSelect.classList.remove('bg-gray-100');
                    toYearSelect.classList.add('focus:ring-blue-500');
                }
            }

            // Initialize all checkboxes on page load
            document.querySelectorAll('input[name="is_present"]').forEach(checkbox => {
                // Only proceed if checkbox exists
                if (!checkbox) return;

                // Handle initial state
                handlePresentCheckbox(checkbox);

                // Add event listener for changes
                checkbox.addEventListener('change', function() {
                    handlePresentCheckbox(this);
                });
            });

            // If you have a specific checkbox with ID (for individual handling)
            const specificCheckbox = document.getElementById('is_present');
            const specificToYear = document.getElementById('to_year_select');

            if (specificCheckbox && specificToYear) {
                handlePresentCheckbox(specificCheckbox);
                specificCheckbox.addEventListener('change', function() {
                    handlePresentCheckbox(this);
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#year_picker", {
                dateFormat: "Y",
                defaultDate: "{{ old('year', date('Y')) }}",
                minDate: "1900",
                maxDate: "{{ date('Y') }}",

                // This makes it show year-only in the input
                onChange: function(selectedDates, dateStr, instance) {
                    instance.input.value = selectedDates[0].getFullYear();
                }
            });

            flatpickr("#to_year_select", {
                dateFormat: "Y",
                defaultDate: "{{ old('year', date('Y')) }}",
                minDate: "1900",
                maxDate: "{{ date('Y') }}",

                // This makes it show year-only in the input
                onChange: function(selectedDates, dateStr, instance) {
                    instance.input.value = selectedDates[0].getFullYear();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#dob", {
                dateFormat: "d-M-Y",
            });
        });

        function openEditEducationModal(id) {
            // Show loading state
            document.getElementById('edit-education-modal').classList.remove('hidden');
            document.getElementById('edit-education-form').reset();

            // Fetch education data
            fetch(`/education/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate form fields
                    document.getElementById('edit_school').value = data.school || '';
                    document.getElementById('edit_degree').value = data.degree || '';
                    document.getElementById('edit_field_of_study').value = data.field_of_study || '';
                    document.getElementById('edit_education_start_date').value = data.start_date || '';
                    document.getElementById('edit_education_end_date').value = data.end_date || '';
                    document.getElementById('edit_education_description').value = data.description || '';

                    // Set form action
                    document.getElementById('edit-education-form').action = `/education/${data.id}`;
                })
                .catch(error => {
                    console.error('Error fetching education data:', error);
                    alert('Error loading education data. Please try again.');
                    document.getElementById('edit-education-modal').classList.add('hidden');
                });
        }

        function openEditWorkModal(id) {
            document.getElementById('edit-work-modal').classList.remove('hidden');
            document.getElementById('edit-work-form').reset();
            // Fetch work experience data
            fetch(`/work/${id}`)
                .then(response => response.json())
                .then(data => {
                    // Populate form
                    document.getElementById('edit_position').value = data.position;
                    document.getElementById('edit_company').value = data.company;
                    document.getElementById('edit_location').value = data.location || '';
                    document.getElementById('edit_start_date').value = data.start_date.split(' ')[0];
                    document.getElementById('edit_end_date').value = data.end_date ? data.end_date.split(' ')[0] : '';
                    document.getElementById('edit_is_current').checked = data.is_current;
                    document.getElementById('edit_description').value = data.description || '';

                    // Set form action
                    document.getElementById('edit-work-form').action = `/work/${id}`;

                    // Show modal
                    document.getElementById('edit-work-modal').classList.remove('hidden');
                });
        }

        // For the add form
        document.getElementById('is_current')?.addEventListener('change', function() {
            if (this.checked) {
                if (confirm(
                        'Marking this as current will automatically unmark any previously current job. Continue?'
                    )) {
                    document.getElementById('end_date').value = '';
                    document.getElementById('end_date').disabled = true;
                } else {
                    this.checked = false; // Uncheck if user cancels
                }
            } else {
                document.getElementById('end_date').disabled = false;
            }
        });

        // For the edit form
        document.getElementById('edit_is_current')?.addEventListener('change', function() {
            if (this.checked) {
                if (confirm(
                        'Marking this as current will automatically unmark any previously current job. Continue?'
                    )) {
                    document.getElementById('edit_end_date').value = '';
                    document.getElementById('edit_end_date').disabled = true;
                } else {
                    this.checked = false; // Uncheck if user cancels
                }
            } else {
                document.getElementById('edit_end_date').disabled = false;
            }
        });

        // Form submission handler
        document.getElementById('work-form')?.addEventListener('submit', function(e) {
            const isCurrent = document.getElementById('is_current')?.checked;
            if (isCurrent) {
                document.getElementById('end_date').value = '';
            }
        });

        document.getElementById('edit-work-form')?.addEventListener('submit', function(e) {
            const isCurrent = document.getElementById('edit_is_current')?.checked;
            if (isCurrent) {
                document.getElementById('edit_end_date').value = '';
            }
        });


        // function performSearch(inputElement, resultsContainer) {
        //     const query = inputElement.value;
        //     if (query.length < 2) {
        //         resultsContainer.classList.add('hidden');
        //         return;
        //     }

        //     fetch(`/search-following?q=${encodeURIComponent(query)}`)
        //         .then(response => response.json())
        //         .then(data => {
        //             resultsContainer.innerHTML = '';

        //             if (data.length === 0) {
        //                 resultsContainer.innerHTML = '<div class="p-2 text-gray-500">No matching friends found</div>';
        //             } else {
        //                 data.forEach(user => {
        //                     const userElement = document.createElement('div');
        //                     userElement.className = 'p-2 hover:bg-gray-100 cursor-pointer flex items-center';

        //                     // User avatar (if available)
        //                     const avatar = user.profile_photo_path ?
        //                         `<img src="${user.profile_photo_path}" class="w-8 h-8 rounded-full mr-2">` :
        //                         `<div class="w-8 h-8 rounded-full bg-gray-300 mr-2 flex items-center justify-center">
    //                      <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
    //                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
    //                      </svg>
    //                    </div>`;

        //                     // User info
        //                     userElement.innerHTML = `
    //                 ${avatar}
    //                 <div>
    //                     <div class="font-medium">${user.full_name}</div>
    //                     ${user.email ? `<div class="text-xs text-gray-500">${user.email}</div>` : ''}
    //                 </div>
    //             `;

        //                     userElement.onclick = () => {
        //                         // Set both the display value and hidden ID value
        //                         inputElement.value = user.full_name;

        //                         // Find or create the hidden input for the ID
        //                         let hiddenInput = document.getElementById('user-id-input');
        //                         if (!hiddenInput) {
        //                             hiddenInput = document.createElement('input');
        //                             hiddenInput.type = 'hidden';
        //                             hiddenInput.id = 'user-id-input';
        //                             hiddenInput.name = 'partner_id';
        //                             inputElement.insertAdjacentElement('afterend', hiddenInput);
        //                         }
        //                         hiddenInput.value = user.id;

        //                         resultsContainer.classList.add('hidden');
        //                     };

        //                     resultsContainer.appendChild(userElement);
        //                 });
        //             }

        //             resultsContainer.classList.remove('hidden');
        //         });
        // }

        // // Partner search
        // document.getElementById('friend-search').addEventListener('input', function(e) {
        //     performSearch(this, document.getElementById('friend-results'));
        // });

        // Shared search function
        document.addEventListener('DOMContentLoaded', function() {
            // Partner search elements
            const friendSearch = document.getElementById('friend-search');
            const friendResults = document.getElementById('friend-results');

            // Family member search elements
            const familyMemberSearch = document.getElementById('family-member-search');
            const familyMemberResults = document.getElementById('family-member-results');

            // Only initialize if elements exist
            if (friendSearch && friendResults) {
                friendSearch.addEventListener('input', function(e) {
                    performSearch(this, friendResults, 'user-id-input', 'partner_id');
                });
            }

            if (familyMemberSearch && familyMemberResults) {
                familyMemberSearch.addEventListener('input', function(e) {
                    performSearch(this, familyMemberResults, 'family-member-id-input', 'family_member_id');
                });
            }

            // Shared search function
            function performSearch(inputElement, resultsContainer, hiddenInputId, hiddenInputName) {
                const query = inputElement.value;
                if (query.length < 2) {
                    if (resultsContainer) resultsContainer.classList.add('hidden');
                    return;
                }

                fetch(`/search-following?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!resultsContainer) return;

                        resultsContainer.innerHTML = '';

                        if (data.length === 0) {
                            resultsContainer.innerHTML =
                                '<div class="p-2 text-gray-500">No matching friends found</div>';
                        } else {
                            data.forEach(user => {
                                const userElement = document.createElement('div');
                                userElement.className =
                                    'p-2 hover:bg-gray-100 cursor-pointer flex items-center';

                                // User avatar
                                const avatar = user.image ?
                                    `<img src="${user.image}" class="w-8 h-8 rounded-full mr-2">` :
                                    `<div class="w-8 h-8 rounded-full bg-gray-300 mr-2 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>`;

                                // User info
                                userElement.innerHTML = `
                            ${avatar}
                            <div>
                                <div class="font-medium">${user.full_name}</div>
                                <div class="text-xs text-gray-500">${user.email}</div>
                                ${user.phone ? `<div class="text-xs text-gray-500">${user.phone}</div>` : ''}
                            </div>
                        `;

                                userElement.onclick = () => {
                                    inputElement.value = user.full_name;

                                    // Set hidden input value
                                    let hiddenInput = document.getElementById(hiddenInputId);
                                    if (!hiddenInput) {
                                        hiddenInput = document.createElement('input');
                                        hiddenInput.type = 'hidden';
                                        hiddenInput.id = hiddenInputId;
                                        hiddenInput.name = hiddenInputName;
                                        inputElement.insertAdjacentElement('afterend', hiddenInput);
                                    }
                                    hiddenInput.value = user.id;

                                    if (resultsContainer) resultsContainer.classList.add('hidden');
                                };

                                resultsContainer.appendChild(userElement);
                            });
                        }
                        resultsContainer.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        if (resultsContainer) {
                            resultsContainer.innerHTML =
                                '<div class="p-2 text-red-500">Error loading results</div>';
                        }
                    });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#anniversary_date", {
                dateFormat: "Y-m-d",
                maxDate: "today", // This prevents future dates
                allowInput: true, // Allows manual input while still validating
                onReady: function(selectedDates, dateStr, instance) {
                    // Optional: Add clear button
                    instance.clearButton = instance._createElement(
                        'a',
                        'flatpickr-clear',
                        'Clear'
                    );
                    instance.clearButton.addEventListener('click', () => {
                        instance.clear();
                    });
                    instance.calendarContainer.appendChild(instance.clearButton);
                }
            });
        });
    </script>
@endsection
@endsection
