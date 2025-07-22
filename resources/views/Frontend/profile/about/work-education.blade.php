<div id="work" class="mb-8 tab-content {{ (isset($tab) && $tab == 'work-education') ? '' : 'hidden' }}">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Work and Education</h2>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Work Section -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Work</h3>
            @if($user->id == Auth::id())
            <button class="text-blue-500 hover:text-blue-600" id="addWorkBtn">Add workplace</button>
            @endif
        </div>

        <!-- Work Experience Items -->
        @foreach ($works as $work)
            <div class="bg-white rounded-lg shadow p-4 mb-3">
                <div class="flex justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-briefcase text-blue-500"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">{{ $work->position }}</h4>
                            <p class="text-gray-600 text-sm">{{ $work->company }}</p>
                            <p class="text-gray-500 text-xs">
                                {{ $work->start_date->format('M Y') }} -
                                {{ $work->is_current ? 'Present' : ($work->end_date ? $work->end_date->format('M Y') : 'Present') }}
                                ·
                                {{ $work->duration }}
                            </p>
                            @if ($work->location)
                                <p class="text-gray-500 text-xs">{{ $work->location }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        @if($user->id == Auth::id())
                        <button class="text-gray-500 hover:text-gray-700" onclick="openEditWorkModal('{{ $work->id }}')">
                            <i class="fas fa-pen mr-2"></i>
                        </button>
                        <button class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Add Work Form (Hidden by default) -->
        <div id="work-form" class="bg-white rounded-lg shadow p-4 {{ $errors->work->any() ? '' : 'hidden' }}">
            <form action="{{ route('work.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    @if ($errors->work->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <ul>
                                @foreach ($errors->work->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="position" class="block text-gray-700 text-sm font-medium mb-1">Position</label>
                        <input type="text" id="position" name="position" value="{{ old('position') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="company" class="block text-gray-700 text-sm font-medium mb-1">Company</label>
                        <input type="text" id="company" name="company" value="{{ old('company') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="location" class="block text-gray-700 text-sm font-medium mb-1">Location</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-gray-700 text-sm font-medium mb-1">Start
                                Date</label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="end_date" class="block text-gray-700 text-sm font-medium mb-1">End Date</label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="mt-2 flex items-center">
                                <input type="checkbox" id="is_current" name="is_current" value="1"
                                    {{ old('is_current') ? 'checked' : '' }} class="mr-2"
                                    onchange="document.getElementById('end_date').disabled = this.checked">
                                <label for="is_current" class="text-sm text-gray-600">I currently work here</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="description"
                            class="block text-gray-700 text-sm font-medium mb-1">Description</label>
                        <textarea id="description" name="description"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="document.getElementById('work-form').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Work Modal (Hidden by default) -->
        <div id="edit-work-modal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Edit Work Experience</h3>
                    <button onclick="document.getElementById('edit-work-modal').classList.add('hidden')"
                        class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="edit-work-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="edit_position"
                                class="block text-gray-700 text-sm font-medium mb-1">Position</label>
                            <input type="text" id="edit_position" name="position"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="edit_company"
                                class="block text-gray-700 text-sm font-medium mb-1">Company</label>
                            <input type="text" id="edit_company" name="company"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="edit_location"
                                class="block text-gray-700 text-sm font-medium mb-1">Location</label>
                            <input type="text" id="edit_location" name="location"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_start_date"
                                    class="block text-gray-700 text-sm font-medium mb-1">Start Date</label>
                                <input type="date" id="edit_start_date" name="start_date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div>
                                <label for="edit_end_date" class="block text-gray-700 text-sm font-medium mb-1">End
                                    Date</label>
                                <input type="date" id="edit_end_date" name="end_date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <div class="mt-2 flex items-center">
                                    <input type="checkbox" id="edit_is_current" name="is_current" value="1"
                                        class="mr-2"
                                        onchange="document.getElementById('edit_end_date').disabled = this.checked">
                                    <label for="edit_is_current" class="text-sm text-gray-600">I currently work
                                        here</label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="edit_description"
                                class="block text-gray-700 text-sm font-medium mb-1">Description</label>
                            <textarea id="edit_description" name="description"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                rows="3"></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                onclick="document.getElementById('edit-work-modal').classList.add('hidden')"
                                class="px-4 py-2 border border-gray-300 rounded-md font-medium">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Education Section -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Education</h3>
            @if($user->id == Auth::id())
            <button class="text-blue-500 hover:text-blue-600" id="addSchoolBtn">Add school</button>
            @endif
        </div>

        <!-- Education Items -->
        @foreach ($educations as $education)
            <div class="bg-white rounded-lg shadow p-4 mb-3">
                <div class="flex justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-blue-500"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">{{ $education->degree }}</h4>
                            <p class="text-gray-600 text-sm">{{ $education->school }}</p>
                            @if ($education->field_of_study)
                                <p class="text-gray-600 text-sm">{{ $education->field_of_study }}</p>
                            @endif
                            <p class="text-gray-500 text-xs">
                                {{ $education->start_date->format('Y') }} -
                                {{ $education->end_date ? $education->end_date->format('Y') : 'Present' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        @if($user->id == Auth::id())
                        <button type="button" class="text-gray-500 hover:text-gray-700"
                            onclick="openEditEducationModal('{{ $education->id }}')">
                            <i class="fas fa-pen mr-2"></i>
                        </button>
                        <button class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Add Education Form (Hidden by default) -->
        <div id="education-form"
            class="bg-white rounded-lg shadow p-4 {{ $errors->education->any() ? '' : 'hidden' }}">
            <form action="{{ route('education.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    @if ($errors->education->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <ul>
                                @foreach ($errors->education->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="school" class="block text-gray-700 text-sm font-medium mb-1">School</label>
                        <input type="text" id="school" name="school" value="{{ old('school') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="degree" class="block text-gray-700 text-sm font-medium mb-1">Degree</label>
                        <input type="text" id="degree" name="degree" value="{{ old('degree') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="field_of_study" class="block text-gray-700 text-sm font-medium mb-1">Field of
                            Study</label>
                        <input type="text" id="field_of_study" name="field_of_study"
                            value="{{ old('field_of_study') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="education_start_date"
                                class="block text-gray-700 text-sm font-medium mb-1">Start Date</label>
                            <input type="date" id="education_start_date" name="start_date"
                                value="{{ old('start_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="education_end_date" class="block text-gray-700 text-sm font-medium mb-1">End
                                Date</label>
                            <input type="date" id="education_end_date" name="end_date"
                                value="{{ old('end_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label for="education_description"
                            class="block text-gray-700 text-sm font-medium mb-1">Description</label>
                        <textarea id="education_description" name="description"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            onclick="document.getElementById('education-form').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Education Modal (Hidden by default) -->
        <div id="edit-education-modal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Edit Education</h3>
                    <button onclick="document.getElementById('edit-education-modal').classList.add('hidden')"
                        class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="edit-education-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="edit_school"
                                class="block text-gray-700 text-sm font-medium mb-1">School</label>
                            <input type="text" id="edit_school" name="school"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="edit_degree"
                                class="block text-gray-700 text-sm font-medium mb-1">Degree</label>
                            <input type="text" id="edit_degree" name="degree"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="edit_field_of_study"
                                class="block text-gray-700 text-sm font-medium mb-1">Field of Study</label>
                            <input type="text" id="edit_field_of_study" name="field_of_study"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_education_start_date"
                                    class="block text-gray-700 text-sm font-medium mb-1">Start Date</label>
                                <input type="date" id="edit_education_start_date" name="start_date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div>
                                <label for="edit_education_end_date"
                                    class="block text-gray-700 text-sm font-medium mb-1">End Date</label>
                                <input type="date" id="edit_education_end_date" name="end_date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label for="edit_education_description"
                                class="block text-gray-700 text-sm font-medium mb-1">Description</label>
                            <textarea id="edit_education_description" name="description"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                rows="3"></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                onclick="document.getElementById('edit-education-modal').classList.add('hidden')"
                                class="px-4 py-2 border border-gray-300 rounded-md font-medium">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
