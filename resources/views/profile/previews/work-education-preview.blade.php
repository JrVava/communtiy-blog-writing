{{-- If Workplace Available Start Here --}}
@if ($user->workPlace->count() > 0)
    @foreach ($user->workPlace as $workPlace)
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex mb-4 justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button class="dropdown-item edit-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editWorkPlaceModal" data-workplace="{{ $workPlace->workplace }}"
                                    data-position="{{ $workPlace->position }}"
                                    data-start_date="{{ $workPlace->start_date }}"
                                    data-end_date="{{ $workPlace->end_date }}" data-city="{{ $workPlace->city }}"
                                    data-description="{{ $workPlace->description }}" data-type="{{ $workPlace->type }}"
                                    data-workplace_id="{{ $workPlace->id }}">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('delete-workplace', ['id' => $workPlace->id]) }}">
                                    Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mb-3 text-start">
                    @php
                        $degree = 'Position';
                        if ($workPlace->type == 'High School' || $workPlace->type == 'College') {
                            $degree = 'Degree';
                        }
                    @endphp
                    <label for="currentWork" class="form-label fw-bold">{{ $workPlace->type }}:</label>
                    <p id="currentWork">{{ $workPlace->workplace }}</p> <!-- Displaying Information -->
                </div>

                <div class="mb-3 text-start">
                    <label for="education" class="form-label fw-bold">{{ $degree }}:</label>
                    <p id="education">{{ $workPlace->position }}</p> <!-- Displaying Information -->
                </div>

                <div class="mb-3 text-start">
                    <label for="livedIn" class="form-label fw-bold">Start Date:</label>
                    <p id="livedIn">{{ $workPlace->start_date }}</p> <!-- Displaying Information -->
                </div>

                <div class="mb-3 text-start">
                    <label for="from" class="form-label fw-bold">End Date:</label>
                    <p id="from">{{ $workPlace->end_date }}A</p> <!-- Displaying Information -->
                </div>

                <div class="mb-3 text-start">
                    <label for="maritalStatus" class="form-label fw-bold">City/Town:</label>
                    <p id="maritalStatus">{{ $workPlace->city }}</p> <!-- Displaying Information -->
                </div>

                <div class="mb-3 text-start">
                    <label for="contactDetails" class="form-label fw-bold">Description:</label>
                    <p id="description">{{ $workPlace->description }}</p>
                </div>
            </div>
        </div>
    @endforeach
@endif
{{-- If Workplace Available End Here --}}

