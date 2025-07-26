<div id="contact-info" class="mb-8 tab-content {{ isset($tab) && $tab == 'contact-info' ? '' : 'hidden' }}">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Contact and Basic Info</h2>
    </div>

    <!-- Contact Information Section -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Contact Information</h3>
            @if($user->id == Auth::id())
            <button class="text-blue-500 hover:text-blue-600" id="addContactBtn">Add contact info</button>
            @endif
        </div>

        <!-- Contact Info Items -->
        <div class="space-y-3">
            @foreach ($contacts as $contact)
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                @switch($contact->type)
                                    @case('email')
                                        <i class="fas fa-envelope text-blue-500"></i>
                                    @break

                                    @case('phone')
                                        <i class="fas fa-phone text-blue-500"></i>
                                    @break

                                    @case('website')
                                        <i class="fas fa-link text-blue-500"></i>
                                    @break

                                    @case('social')
                                        <i class="fas fa-share-alt text-blue-500"></i>
                                    @break
                                @endswitch
                            </div>
                            <div>
                                <h4 class="font-medium">{{ ucfirst($contact->type) }}</h4>
                                <p class="text-gray-600 text-sm">{{ $contact->value }}</p>
                                @if ($contact->is_primary)
                                    <p class="text-gray-500 text-xs">Primary</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('profile.contact-info.delete', $contact->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Add Contact Form (Hidden by default) -->
        <div id="contact-form" class="bg-white rounded-lg shadow p-4 hidden mt-4">
            <form method="POST" action="{{ route('profile.contact-info.add') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Contact Type</label>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            name="type">
                            <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>Phone</option>
                            <option value="website" {{ old('type') == 'website' ? 'selected' : '' }}>Website</option>
                            <option value="social" {{ old('type') == 'social' ? 'selected' : '' }}>Social Link</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Value</label>
                        <input type="text" name="value"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter contact information">
                        @error('value')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="primary-contact"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" name="is_primary"
                            value="1">
                        <label for="primary-contact" class="ml-2 block text-sm text-gray-700">Set as primary
                            contact</label>
                        @error('is_primary')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-contact-form">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Basic Information Section -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Basic Information</h3>
            {{-- @if (!$basicInfo->exists) --}}
            @if($user->id == Auth::id())
            <button class="text-blue-500 hover:text-blue-600" id="editBasicInfoBtn">
                 @if (!$basicInfo->exists)
                 Create Basic Info
                 @else
                 Edit Basic Info
                @endif
            </button>
            @endif
        </div>

        <!-- Basic Info Items -->
        @if ($basicInfo->exists)
            <!-- Display Basic Info -->
            <div class="space-y-3">
                <!-- Birthday -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-birthday-cake text-blue-500"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Birthday</h4>
                                <p class="text-gray-600 text-sm">
                                    {{ $basicInfo->birthday ? $basicInfo->birthday->format('F j, Y') : 'Not specified' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gender -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-venus-mars text-blue-500"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Gender</h4>
                                <p class="text-gray-600 text-sm">
                                    {{ $basicInfo->gender ? ucfirst($basicInfo->gender) : 'Not specified' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Languages -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-language text-blue-500"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Languages</h4>
                                <p class="text-gray-600 text-sm">
                                    @if ($basicInfo->languages && count($basicInfo->languages) > 0)
                                        @foreach ($basicInfo->languages as $language)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $language }}
                                            </span>
                                        @endforeach
                                    @else
                                        Not specified
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Edit Basic Info Form (Hidden by default) -->
        <div id="basic-info-form" class="bg-white rounded-lg hidden shadow p-4 mt-4">
            <form method="POST" action="{{ route('profile.contact-info.basic.create') }}">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Birthday</label>
                            <input type="text" id="dob" name="birthday"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Date of birth"
                                value="{{ isset($basicInfo->birthday) ? \Carbon\Carbon::parse($basicInfo->birthday)->format('d-M-Y') : '' }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Gender</label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                name="gender">
                                <option value="">Select Gender</option>
                                <option value="male"
                                    {{ isset($basicInfo->gender) && $basicInfo->gender == 'male' ? 'selected' : '' }}>
                                    Male
                                </option>
                                <option value="female"
                                    {{ isset($basicInfo->gender) && $basicInfo->gender == 'female' ? 'selected' : '' }}>
                                    Female</option>
                                <option value="other"
                                    {{ isset($basicInfo->gender) && $basicInfo->gender == 'other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex justify-between">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-language text-blue-500"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium">Languages</h4>
                                    <div id="language-tags-container" class="flex flex-wrap gap-2">
                                        <!-- Existing language tags will appear here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Languages Form (Hidden by default) -->
                    <!-- Inside your languages-form div, keep the input field visible -->
                    <div id="languages-form" class="bg-white rounded-lg shadow p-4 mt-4">
                        <!-- Removed 'hidden' class -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Add Language</label>
                                <div class="flex items-center space-x-2">
                                    <input type="text" id="language-input"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter language">
                                    <button id="add-language-btn"
                                        class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="language-tags-container" class="flex flex-wrap gap-2">
                                <!-- Existing language tags will appear here -->
                            </div>
                        </div>
                    </div>

                    <!-- Add this hidden container for form submission -->
                    <div id="language-inputs-container" class="hidden"></div>
                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-basic-info-form">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
