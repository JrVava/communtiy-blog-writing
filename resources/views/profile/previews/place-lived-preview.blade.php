@if ($user->placeLived->count() > 0)
@foreach ($user->placeLived as $placeLive)
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <div class="d-flex mb-4 justify-content-end">

                <div class="dropdown">
                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <button 
                            class="dropdown-item edit-button editPlaceLiveModal" 
                            type="button" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editPlaceLiveModal"
                            data-place="{{ $placeLive->place }}"
                            data-date_moved="{{ $placeLive->date_moved }}"
                            data-place_lived_id="{{ $placeLive->id }}"
                            data-place_type="{{ $placeLive->place_type }}"
                          >
                            Edit
                          </button>
                          
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('delete-place-lived',['id' => $placeLive->id]) }}">
                                Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mb-3 text-start">
                <label for="place" class="form-label fw-bold">Place Type:</label>
                <p id="place">{{ $placeLive->place_type }}</p> <!-- Displaying Information -->
            </div>
            <div class="mb-3 text-start">
                <label for="place" class="form-label fw-bold">Place:</label>
                <p id="place">{{ $placeLive->place }}</p> <!-- Displaying Information -->
            </div>

            <div class="mb-3 text-start">
                <label for="date_moved" class="form-label fw-bold">Date Moved:</label>
                <p id="date_moved">{{ $placeLive->date_moved }}</p> <!-- Displaying Information -->
            </div>
        </div>
    </div>
@endforeach
@endif