<div id="places" class="mb-8 tab-content {{ (isset($tab) && $tab == 'place-lived') ? '' : 'hidden' }}">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Places Lived</h2>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Current City Section -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Current City</h3>
            @if($user->id == Auth::id())
            @if (!$currentCity)
                <button class="text-blue-500 hover:text-blue-600" id="addCurrentCityBtn">
                    Add city
                </button>
            @endif
            @endif
        </div>

        @if ($currentCity)
            <!-- Current City Item -->
            <div class="bg-white rounded-lg shadow p-4 mb-3">
                <div class="flex justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-blue-500"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">{{ $currentCity->city }}</h4>
                            <p class="text-gray-500 text-xs">{{ $currentCity->state }}, {{ $currentCity->country }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <form action="{{ route('places.destroy', $currentCity->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-gray-700"
                                onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Add/Edit Current City Form (Hidden by default) -->
        <div id="current-city-form" class="bg-white rounded-lg shadow p-4 hidden">
            <form action="{{ route('places.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="current_city">
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">City</label>
                        <input type="text" name="city"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter city name">
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">State</label>
                        <input type="text" name="state"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter state name">
                        @error('state')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Country</label>
                        <input type="text" name="country"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter country name">
                        @error('country')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-places-form">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hometown Section -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Hometown</h3>
            @if($user->id == Auth::id())
            @if (!$hometown)
                <button class="text-blue-500 hover:text-blue-600" id="addHometownBtn">
                    Add hometown
                </button>
            @endif
            @endif
        </div>

        @if ($hometown)
            <!-- Hometown Item -->
            <div class="bg-white rounded-lg shadow p-4 mb-3">
                <div class="flex justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-home text-blue-500"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">{{ $hometown->city }}</h4>
                            <p class="text-gray-500 text-xs">{{ $hometown->state }}, {{ $hometown->country }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <form action="{{ route('places.destroy', $hometown->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-gray-700"
                                onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Add/Edit Hometown Form (Hidden by default) -->
        <div id="hometown-form" class="bg-white rounded-lg shadow p-4 hidden">
            <form action="{{ route('places.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="hometown">
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Hometown</label>
                        <input type="text" name="city"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter hometown">
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">State</label>
                        <input type="text" name="state"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter state name">
                        @error('state')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Country</label>
                        <input type="text" name="country"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter country name">
                        @error('country')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-places-form">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Other Places Section -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Other Places</h3>
            @if($user->id == Auth::id())
            <button class="text-blue-500 hover:text-blue-600" id="addOtherPlaceBtn">Add place</button>
            @endif
        </div>

        @foreach ($otherPlaces as $place)
            <!-- Other Place Item -->
            <div class="bg-white rounded-lg shadow p-4 mb-3">
                <div class="flex justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-globe-americas text-blue-500"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">{{ $place->city }}</h4>
                            <p class="text-gray-500 text-xs">{{ $place->state }}, {{ $place->country }}</p>
                            <p class="text-gray-500 text-xs">
                                {{ $place->from_year }} - {{ $place->is_present ? 'Present' : $place->to_year }}
                            </p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <form action="{{ route('places.destroy', $place->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-gray-700"
                                onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Add Other Place Form (Hidden by default) -->
        <div id="other-place-form" class="bg-white rounded-lg shadow p-4 hidden">
            <form action="{{ route('places.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="other">
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Place</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter place name">
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">State</label>
                        <input type="text" name="state" value="{{ old('state') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter state name">
                        @error('state')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Country</label>
                        <input type="text" name="country" value="{{ old('country') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter country name">
                        @error('country')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">From</label>
                            <input type="text" name="from_year" name="year" min="1900"
                                max="{{ date('Y') }}" step="1" id="year_picker"
                                value="{{ old('year', date('Y')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter year (1900-{{ date('Y') }})">
                            @error('from_year')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="to-year-container">
                            <label class="block text-gray-700 text-sm font-medium mb-1">To</label>
                            <input type="text" name="to_year" min="1900"
                                max="{{ date('Y') }}" step="1" id="to_year_select"
                                value="{{ old('to_year', date('Y')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter year (1900-{{ date('Y') }})">

                            {{-- <select name="to_year" id="to_year_select"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Year</option>
                                @for ($year = date('Y'); $year >= 1900; $year--)
                                    <option value="{{ $year }}"
                                        {{ old('to_year', $place->to_year ?? '') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select> --}}
                            @error('to_year')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <div class="flex items-center mt-2">
                                <input type="checkbox" name="is_present" id="is_present" value="1"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ old('is_present', $place->is_present ?? false) ? 'checked' : '' }}>
                                <label for="is_present" class="ml-2 text-sm text-gray-700">I currently live
                                    here</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-places-form">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
