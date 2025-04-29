<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm" id="contactInfoFormCard">
            <div class="card-body">
                <!-- Contact and Basic Info Form -->
                <form method="post" action="{{ route('add-update-contact-basic-info') }}">
                    @csrf
                    @if(isset($user->contactBasicInfo->id))
                    <input type="hidden" name="contact_basic_id" value="{{ $user->contactBasicInfo->id }}">
                    @endif
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email_address" placeholder="Enter email address" value="{{ isset($user->contactBasicInfo) ? $user->contactBasicInfo->email_address : '' }}">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone_number" placeholder="Enter phone number" value="{{ isset($user->contactBasicInfo) ? $user->contactBasicInfo->phone_number : '' }}">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="relationshipStatus" class="form-label">Relationship Status</label>
                        <select class="form-select" id="relationshipStatus" name="relationship_status">
                            <option value="">Select status</option>
                            <option value="single" @if(isset($user->contactBasicInfo) && $user->contactBasicInfo->relationship_status == 'single') selected @endif>Single</option>
                            <option value="in_a_relationship" @if(isset($user->contactBasicInfo) && $user->contactBasicInfo->relationship_status == 'in_a_relationship') selected @endif>In a Relationship</option>
                            <option value="engaged" @if(isset($user->contactBasicInfo) && $user->contactBasicInfo->relationship_status == 'engaged') selected @endif>Engaged</option>
                            <option value="married" @if(isset($user->contactBasicInfo) && $user->contactBasicInfo->relationship_status == 'married') selected @endif>Married</option>
                            <option value="complicated" @if(isset($user->contactBasicInfo) && $user->contactBasicInfo->relationship_status == 'complicated') selected @endif>It's Complicated</option>
                        </select>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" value="{{ isset($user->contactBasicInfo) ? $user->contactBasicInfo->birthday : '' }}">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" value="{{ isset($user->contactBasicInfo) ? $user->contactBasicInfo->address : '' }}">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="website" placeholder="Enter website URL" name="website" value="{{ isset($user->contactBasicInfo) ? $user->contactBasicInfo->website : '' }}">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" rows="4" placeholder="Write something about yourself" name="bio">{{ isset($user->contactBasicInfo) ? $user->contactBasicInfo->bio : '' }}</textarea>
                    </div>

                    <!-- Social Media URLs -->
                    <div class="mb-3 text-start">
                        <label class="form-label">Social Media URLs</label>
                        <div id="socialMediaUrls">
                            @if(isset($user->contactBasicInfo) && $user->contactBasicInfo->socialMedia->count() > 0)
                            @foreach($user->contactBasicInfo->socialMedia as $social_media)
                            <div class="input-group mb-3 social-media-group">
                                <input type="text" class="form-control" placeholder="Enter Social Media URL" name="social_media_url[]" value="{{ $social_media->social_media_url }}">
                                <a class="btn btn-danger remove-social" href="{{ route('delete-social-media-url',['id' => $social_media->id]) }}">-</a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-success" id="addSocialMediaUrlBtn">+ Add Social Media</button>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>