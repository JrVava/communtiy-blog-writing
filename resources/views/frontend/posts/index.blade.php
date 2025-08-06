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
@section('title','On Track Eductaion - Home')
@section('content')
    <div class="container mx-auto px-4 mt-[50px] md:mt-0 py-6 flex flex-col md:flex-row gap-6">
        <!-- Left Sidebar - Community Navigation (Hidden on mobile) -->
        <aside class="hidden md:block md:w-1/4 lg:w-1/5 bg-white rounded-lg shadow-md p-4 sticky top-20 self-start">
            <h2 class="text-xl font-bold mb-4">Community</h2>
            <nav class="space-y-2">
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-home mr-2"></i> Home</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-users mr-2"></i> My
                    Groups</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-comments mr-2"></i>
                    Discussions</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-calendar-alt mr-2"></i>
                    Events</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-book mr-2"></i>
                    Resources</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100"><i class="fas fa-cog mr-2"></i>
                    Settings</a>
            </nav>
        </aside>

        <!-- Main Content - Create Post -->
        <main class="content-area flex-1">
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <img src="@if (isset(Auth::user()->currentProfileImage->path)) {{ Storage::url(Auth::user()->currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif" alt="User Avatar"
                            class="w-10 h-10 rounded-full object-cover border border-gray-200">
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
                                    Post <i class="fas fa-paper-plane text-sm"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @foreach ($posts as $post)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" data-post-id="{{ $post->id }}">
                        <!-- ... (previous post content) ... -->
                        <!-- Post Header -->
                        <div class="p-4 flex items-center space-x-3">
                            <img src="@if (isset($post->user->currentProfileImage)) {{ Storage::url($post->user->currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif"
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
                                    $reactionCounts = $post->reactions ? $post->reactions->getReactionCounts() : [];
                                    $totalReactions = $post->reactions ? $post->reactions->getTotalReactions() : 0;
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
                                    <span class="reaction-count text-sm text-gray-500">{{ $totalReactions }}</span>
                                @endif
                            </div>
                            <span class="comment-count"
                                data-post-id="{{ $post->id }}">{{ $post->comments_count ?? 0 }} comments</span>
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
                                <div
                                    class="emoji-picker absolute bottom-full left-0 bg-white shadow-lg rounded-full p-2 hidden">
                                    <div class="flex space-x-2">
                                        @foreach ($reactions as $type => $emoji)
                                            <span
                                                class="emoji-option hover:scale-125 transition-transform cursor-pointer text-xl"
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
                                                    <h4 class="font-semibold text-sm">{{ $comment->user->full_name }}</h4>
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
            </div>
        </main>

        <!-- Right Sidebar - Events (Hidden on mobile) -->
        <aside class="hidden md:block md:w-1/4 lg:w-1/5 space-y-4 sticky top-20 self-start">
            <!-- First Card - Upcoming Events -->
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
                            <p class="text-sm text-gray-600 mt-1">Community guidelines updated - please review</p>
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
                            <p class="text-sm text-gray-600 mt-1">Share your ideas for community improvement</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
@section('scripts')
    <script>
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
                        <img src="${data.comment.user.currentProfileImage.path}" 
                            alt="${data.comment.user.full_name}" 
                            class="w-8 h-8 rounded-full mt-1 object-cover">
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
    </script>
@endsection
@endsection
