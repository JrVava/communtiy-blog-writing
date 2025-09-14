<div class="container mx-auto px-4 py-6">
    <!-- Simple Header -->
    <h1 class="text-2xl font-bold mb-6">Friends ({{ $friendList->count() }})</h1>

    <!-- Friends Grid - Simple Version -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <!-- Friend 1 -->
        @foreach ($friendList as $friend)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="@if(isset($friend->currentProfileImage)) {{ Storage::url($friend->currentProfileImage->path) }} @else {{ secure_asset('assets/img/dummy-user.jpg') }} @endif" alt="Friend" class="w-full h-[152px] object-cover">
                <div class="p-3">
                    <h3 class="font-semibold">{{ $friend->full_name }}</h3>
                    {{-- <p class="text-gray-500 text-sm">12 mutual friends</p> --}}
                    <div class="flex mt-2 space-x-1">
                        @if ($user->id == Auth::id())
                            {{-- <button
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-1 text-xs rounded">Message</button> --}}
                            <button class="follow-button flex-1 bg-gray-200 hover:bg-gray-300 py-1 text-xs rounded"
                                data-user-id="{{ $friend->id }}" data-state="following">Following</button>
                        @else
                            @if (!$friend->id)
                                <button class="follow-button flex-1 bg-gray-200 hover:bg-gray-300 py-1 text-xs rounded"
                                    data-user-id="{{ $user->id }}" data-state="follow">Follow</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
