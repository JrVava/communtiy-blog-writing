<div id="family" class="mb-8 tab-content {{ isset($tab) && $tab == 'family-relationship' ? '' : 'hidden' }}">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Family and Relationships</h2>
    </div>

    <!-- Relationship Status Section -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Relationship</h3>
            @if($user->id == Auth::id())
            <button class="text-blue-500 hover:text-blue-600" id="editRelationshipBtn">Edit</button>
            @endif
        </div>

        <!-- Relationship Status Display -->
        <div class="bg-white rounded-lg shadow p-4" id="relationship-display">
            {{-- {{ dd($relationship) }} --}}
            @if ($relationship)
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-heart text-blue-500"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">{{ $relationship->status }}</h4>
                        @if ($relationship->partner)
                            <p class="text-gray-500 text-sm">Partner: {{ $relationship->partner->full_name }}</p>
                        @endif
                        @if ($relationship->anniversary_date)
                            <p class="text-gray-500 text-sm">Anniversary:
                                {{ $relationship->anniversary_date ? $relationship->anniversary_date->format('F j, Y')  : "" }}
                            </p>
                        @endif
                    </div>
                </div>
            @else
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-heart text-blue-500"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Single</h4>
                        <p class="text-gray-500 text-sm">Add your relationship status</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Relationship Form (Hidden by default) -->
        <div id="relationship-form" class="bg-white rounded-lg shadow p-4 hidden mt-4">
            <form method="POST" action="{{ route('relationship.update') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Relationship Status</label>
                        <select id="relationship-status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            name="status">
                            <option value="">Select status</option>
                            @foreach (config('relationship.statuses') as $relationshipStatus)
                                <option value="{{ $relationshipStatus }}"
                                    {{ old('status', $relationship->status ?? '') == $relationshipStatus ? 'selected' : '' }}>
                                    {{ $relationshipStatus }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Partner Name (shown only for certain statuses) -->
                    <div id="partner-name-container" class="@if (!isset($relationship)) hidden @endif">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Partner's Name</label>
                        <input type="text" id="friend-search"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Search your friends"
                            value="{{ isset($relationship->partner->full_name) ? $relationship->partner->full_name : '' }}">
                        <input type="hidden" id="user-id-input" name="partner_id"
                            value="{{ isset($relationship->partner->id) ? $relationship->partner->id : '' }}">
                        <!-- The hidden input will be automatically added by the JavaScript -->
                        <div id="friend-results"
                            class="hidden absolute z-10 w-80 mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto">
                        </div>
                        @error('partner_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Anniversary Date (shown only for certain statuses) -->
                    <div id="anniversary-container" class="hidden">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Anniversary Date</label>
                        <input type="text" name="anniversary_date" id="anniversary_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('anniversary_date', $relationship->anniversary_date ?? '') }}"
                            placeholder="Anniversary Date">
                        @error('anniversary_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-relationship-form">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600"
                            id="save-relationship-btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Family Members Section -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Family Members</h3>
            @if($user->id == Auth::id())
            <button class="text-blue-500 hover:text-blue-600" id="addFamilyMemberBtn">Add family member</button>
            @endif
        </div>

        <!-- Family Members List -->
        <div class="space-y-3" id="family-members-container">
            <!-- Family members will appear here -->
            {{-- <div class="bg-white rounded-lg shadow p-4">
                <p class="text-gray-500 text-sm">Add your family members</p>
            </div> --}}
            @forelse($familyMembers as $member)
            <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-gray-500"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">{{ $member->familyMember->full_name }}</h4>
                        <p class="text-gray-500 text-sm">{{ $member->relationship }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('family.member.remove', $member) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            @empty
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-gray-500 text-sm">Add your family members</p>
                </div>
            @endforelse
        </div>

        <!-- Add Family Member Form (Hidden by default) -->
        <div id="family-member-form" class="bg-white rounded-lg shadow p-4 hidden mt-4">
            <form method="POST" action="{{ route('family.member.add') }}">
                @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Name</label>
                    <input type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter name" id="family-member-search">
                    <input type="hidden" id="family-member-id-input" name="family_member_id">
                    <div id="family-member-results"
                        class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Relationship</label>
                    <select id="family-relationship" name="relationship"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select relationship</option>
                        @foreach (config('relationship.family_relationship') as $relationshipStatus)
                            <option value="{{ $relationshipStatus }}"
                                {{ old('status', $relationship->status ?? '') == $relationshipStatus ? 'selected' : '' }}>
                                {{ $relationshipStatus }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="custom-relationship-container" class="hidden">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Specify Relationship</label>
                    <input type="text" id="custom-relationship"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter relationship">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button"
                        class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-family-member-form">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600"
                        id="save-family-member-btn">Save</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
