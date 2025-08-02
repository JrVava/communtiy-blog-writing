<div id="overview" class="mb-8 tab-content {{ isset($tab) ? 'hidden' : '' }}">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Overview</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Work Card -->
        @if ($work)
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                clip-rule="evenodd" />
                            <path
                                d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold">Work</h3>
                </div>
                <div class="pl-13">
                    <p class="font-medium">{{ $work->position }}</p>
                    <p class="text-gray-600 text-sm">{{ $work->company }}</p>
                    <p class="text-gray-500 text-xs">{{ $work->start_date->format('Y') }} -
                        {{ $work->currently_working ? 'Present' : $work->end_date->format('Y') }} ·
                        {{ $work->location }}</p>
                </div>
            </div>
        @endif
        @if ($education)
            <!-- Education Card -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold">Education</h3>
                </div>
                <div class="pl-13">
                    <p class="font-medium">{{ $education->degree }}</p>
                    <p class="text-gray-600 text-sm">{{ $education->school }}</p>
                    <p class="text-gray-500 text-xs">{{ $education->start_year }} - {{ $education->end_year }} </p>
                </div>
            </div>
        @endif

        @if ($currentCityOverView)
            <!-- Current City Card -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="font-semibold">Current City</h3>
                </div>
                <div class="pl-13">
                    <p class="font-medium">{{ $currentCityOverView->city }}</p>
                    <p class="text-gray-500 text-xs">{{ $currentCityOverView->state }},
                        {{ $currentCityOverView->country }}</p>
                </div>
            </div>
        @endif
        @if ($hometown)
            <!-- Hometown Card -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold">Hometown</h3>
                </div>
                <div class="pl-13">
                    <p class="font-medium">{{ $hometown->city }}</p>
                    <p class="text-gray-500 text-xs">{{ $hometown->state }}, {{ $hometown->country }}</p>
                </div>
            </div>
        @endif

        @if ($relationShip)
            <!-- Relationship Card -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="font-semibold">Relationship</h3>
                </div>
                <div class="pl-13">
                    @if (isset($relationship))
                        <p class="font-medium">{{ $relationship->status }}</p>
                        @if ($relationship->partner)
                            <p class="text-gray-600 text-sm">With {{ $relationship->partner->full_name }}</p>
                        @endif
                        @if ($relationship->anniversary_date)
                            <p class="text-gray-500 text-xs">
                                Since {{ \Carbon\Carbon::parse($relationship->anniversary_date)->format('Y') }}
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        @endif
        <!-- Joined Date Card -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="font-semibold">Joined Facebook</h3>
            </div>
            <div class="pl-13">
                <p class="font-medium">{{ $user->created_at->format('F Y') }}</p>
                <p class="text-gray-500 text-xs">{{ $user->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>
