<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Place Lived</h5>
            <button type="button" class="btn btn-light btn-sm shadow-sm" id="addPlaceLivedBtn">
                + Add a Place
            </button>
        </div>
        <div class="card shadow-sm d-none" id="placeLivedFormCard">
            <div class="card-body">
                <!-- Place Lived Form -->
                <form action="{{route('add-update-place-lived')}}" method="post">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="place" class="form-label">Place</label>
                        <input type="text" class="form-control" name="place" id="place" placeholder="Enter place">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="startDate" class="form-label">Date Moved</label>
                        <input type="date" class="form-control" id="startDate" name="date_moved">
                    </div>

                    <div class="text-start">
                        <button type="button" class="btn btn-light me-2" id="cancelPlaceLivedBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- If Place Lived Available Start Here --}}
        @if ($user->placeLived->count() > 0)
            @foreach ($user->placeLived as $placeLive)
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <div class="d-flex mb-4 justify-content-end">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
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
        {{-- If Place Lived Available End Here --}}
    </div>
</div>


{{-- Model Start Here --}}

<div class="modal fade" id="editPlaceLiveModal" tabindex="-1" aria-labelledby="editPlaceLiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="editPlaceLiveForm" method="post" action="{{ route('add-update-place-lived') }}" class="placeLiveForm">
            @csrf
            <input type="hidden" class="form-control" name="id" id="editPlaceLiveId">
          <div class="modal-header">
            <h5 class="modal-title" id="editPlaceLiveModalLabel">Edit Place Lived</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3 text-start">
              <label class="form-label">Place</label>
              <input type="text" class="form-control" name="place" id="editPlace">
            </div>
            <div class="mb-3 text-start">
              <label class="form-label">Date Moved</label>
              <input type="date" class="form-control" name="date_moved" id="editDateMoved">
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>