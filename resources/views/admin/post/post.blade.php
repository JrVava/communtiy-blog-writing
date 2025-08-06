@extends('layouts.admin-app')
@section('title', 'Post')
@section('content')
    <style>
        /* Improved Admin Panel Layout */

        /* Enhanced Video Player */
        .media-container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .video-wrapper {
            position: relative;
            background: #000;
        }

        /* Adjust video container height */
        .video-wrapper {
            height: 100%;
            max-height: 500px;
            /* Change this value as needed */
            overflow: hidden;
        }

        .video-player {
            height: 100%;
            width: 100%;
            object-fit: contain;
            /* Maintains aspect ratio */
        }

        .video-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            padding: 1rem;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .video-wrapper:hover .video-controls,
        .video-wrapper.controls-visible .video-controls {
            opacity: 1;
        }

        .progress-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .progress-bar {
            height: 100%;
            background: #3498db;
            border-radius: 3px;
            width: 0%;
        }

        .control-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-controls,
        .right-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }


        .control-btn {
            color: white;
            background: transparent;
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
            padding: 5px;
        }

        .control-btn:hover {
            color: #3498db;
        }

        .time-display {
            color: white;
            font-size: 0.9rem;
            font-family: monospace;
        }

        .volume-control {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .volume-slider {
            width: 80px;
            height: 4px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .volume-control:hover .volume-slider {
            opacity: 1;
        }

        /* Post Content */
        .post-content {
            padding: 1.5rem;
            line-height: 1.6;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 1.5rem;
            border-top: 1px solid #eee;
        }

        .btn-approve {
            min-width: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
    </style>


    <!-- Main Content Area -->
    <div class="main-content">
        <div class="media-container">
            @if ($post->media_path)
                @if ($post->media_type === 'image')
                    <img src="{{ $post->media_url }}" alt="Post image" class="img-fluid w-100">
                @elseif($post->media_type === 'video')
                    <div class="video-wrapper">
                        <video class="video-player" loop preload="metadata" playsinline>
                            <source src="{{ $post->media_url }}" type="video/mp4">
                        </video>

                        <div class="video-controls">
                            <div class="progress-container">
                                <div class="progress-bar"></div>
                            </div>

                            <div class="control-bar">
                                <div class="left-controls">
                                    <button class="control-btn play-pause">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <div class="volume-control">
                                        <button class="control-btn volume-btn">
                                            <i class="fas fa-volume-up"></i>
                                        </button>
                                        <input type="range" class="volume-slider" min="0" max="1"
                                            step="0.01" value="1">
                                    </div>
                                    <span class="time-display current-time">00:00</span>
                                </div>

                                <div class="right-controls">
                                    <span class="time-display duration">00:00</span>
                                    <button class="control-btn fullscreen-btn">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="post-content">
                {!! $post->content !!}
            </div>

            <div class="action-buttons">
                @if (!$post->is_approve)
                    <a href="{{ route('admin.post-approve-deny', ['id' => $post->id]) }}"
                        class="btn btn-primary btn-approve">
                        <i class="fas fa-check"></i> Approve
                    </a>
                @else
                    <a href="{{ route('admin.post-approve-deny', ['id' => $post->id]) }}"
                        class="btn btn-outline-danger btn-approve">
                        <i class="fas fa-times"></i> Deny
                    </a>
                @endif
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoWrappers = document.querySelectorAll('.video-wrapper');

            videoWrappers.forEach(wrapper => {
                const video = wrapper.querySelector('video');
                const playPauseBtn = wrapper.querySelector('.play-pause');
                const volumeBtn = wrapper.querySelector('.volume-btn');
                const volumeSlider = wrapper.querySelector('.volume-slider');
                const progressBar = wrapper.querySelector('.progress-bar');
                const currentTimeDisplay = wrapper.querySelector('.current-time');
                const durationDisplay = wrapper.querySelector('.duration');
                const fullscreenBtn = wrapper.querySelector('.fullscreen-btn');
                const progressContainer = wrapper.querySelector('.progress-container');

                // Format time as MM:SS
                function formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = Math.floor(seconds % 60);
                    return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
                }

                // Update video duration display
                video.addEventListener('loadedmetadata', function() {
                    durationDisplay.textContent = formatTime(video.duration);
                });

                // Update progress bar and current time
                video.addEventListener('timeupdate', function() {
                    const percent = (video.currentTime / video.duration) * 100;
                    progressBar.style.width = `${percent}%`;
                    currentTimeDisplay.textContent = formatTime(video.currentTime);
                });

                // Click on progress bar to seek
                progressContainer.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const pos = (e.clientX - rect.left) / rect.width;
                    video.currentTime = pos * video.duration;
                });

                // Play/pause toggle
                playPauseBtn.addEventListener('click', function() {
                    if (video.paused) {
                        video.play();
                        wrapper.classList.add('controls-visible');
                        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                    } else {
                        video.pause();
                        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                    }
                });

                // Video click to play/pause
                video.addEventListener('click', function() {
                    if (video.paused) {
                        video.play();
                        wrapper.classList.add('controls-visible');
                        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                    } else {
                        video.pause();
                        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                    }
                });

                // Volume control
                volumeSlider.addEventListener('input', function() {
                    video.volume = this.value;
                    video.muted = (this.value == 0);
                    updateVolumeIcon();
                });

                volumeBtn.addEventListener('click', function() {
                    video.muted = !video.muted;
                    if (video.muted) {
                        volumeSlider.value = 0;
                    } else {
                        volumeSlider.value = video.volume || 1;
                    }
                    updateVolumeIcon();
                });

                function updateVolumeIcon() {
                    if (video.muted || video.volume == 0) {
                        volumeBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
                    } else if (video.volume < 0.5) {
                        volumeBtn.innerHTML = '<i class="fas fa-volume-down"></i>';
                    } else {
                        volumeBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
                    }
                }

                // Fullscreen toggle
                fullscreenBtn.addEventListener('click', function() {
                    if (!document.fullscreenElement) {
                        wrapper.requestFullscreen().catch(err => {
                            console.error(`Fullscreen error: ${err.message}`);
                        });
                    } else {
                        document.exitFullscreen();
                    }
                });

                // Show controls when paused
                video.addEventListener('pause', function() {
                    wrapper.classList.add('controls-visible');
                });

                // Hide controls after delay when playing
                let controlsTimeout;
                video.addEventListener('play', function() {
                    wrapper.classList.add('controls-visible');
                    clearTimeout(controlsTimeout);
                    controlsTimeout = setTimeout(() => {
                        if (!wrapper.matches(':hover')) {
                            wrapper.classList.remove('controls-visible');
                        }
                    }, 3000);
                });

                // Keep controls visible when hovering
                wrapper.addEventListener('mouseenter', function() {
                    clearTimeout(controlsTimeout);
                    wrapper.classList.add('controls-visible');
                });

                wrapper.addEventListener('mouseleave', function() {
                    if (!video.paused) {
                        controlsTimeout = setTimeout(() => {
                            wrapper.classList.remove('controls-visible');
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endsection
@endsection
