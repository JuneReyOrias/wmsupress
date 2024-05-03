<div>
<!-- murag wtf -->
    <div class="page-content">     
        <div class="container">
            <div class="row justify-content-between">
                <!-- Profile Card -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Profile</h2>
                            <div class="profile-info text-center">
                                <div class="mb-3">
                                    <img src="{{asset('storage/content/profile/'.$profile_details['image']) }}"alt="Profile Image"  class="img-fluid">
                                </div>
                                <div class="mb-3">
                                    <button id="modifyButtonProfile" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifyModal">Edit Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Profile Details Card -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Profile Details</h2>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-white text-black border"><strong>First Name:</strong> {{$profile_details['first_name']}}</li>
                                <li class="list-group-item bg-white text-black border"><strong>Middle Name:</strong> {{$profile_details['middle_name']}}</li>
                                <li class="list-group-item bg-white text-black border"><strong>Last Name:</strong> {{$profile_details['last_name']}}</li>
                                <li class="list-group-item bg-white text-black border"><strong>Account Created:</strong> {{date_format(date_create($profile_details['date_created']),"M d, Y ")}}</li>
                            </ul>
                            <button id="modifyButtonDetails" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modifyModalDetails">Edit Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modify Profile Modal -->
    <div wire:ignore.self class="modal fade" id="modifyModal" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="modifyModalLabel">Modify Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white text-black">
                    <!-- Tab navigation -->
                    <ul class="nav nav-tabs" id="accountSettingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="modifyInfo-tab" data-bs-toggle="tab" href="#modifyInfo" role="tab" aria-controls="modifyInfo" aria-selected="true">Modify Info</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="changePassword-tab" data-bs-toggle="tab" href="#changePassword" role="tab" aria-controls="changePassword" aria-selected="false">Change Password</a>
                        </li>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content mt-3" id="accountSettingsTabContent">
                        <!-- Modify Info Tab -->
                        <div class="tab-pane fade show active" id="modifyInfo" role="tabpanel" aria-labelledby="modifyInfo-tab">
                            <form wire:submit.prevent="save_profile_image()">
                                <div class="mb-3">
                                    <label for="newProfileImage" class="form-label text-black">Change profile picture:</label>
                                    <input type="file" class="form border" wire:model="profile_details.temp_image" id="newProfileImage" accept="image/png, image/jpeg">
                                </div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="changePassword" role="tabpanel" aria-labelledby="changePassword-tab">
                            <form >
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label text-black">Current Password<span style="color:red;">*</span>:</label>
                                    <input type="password" class="form-control" id="currentPassword" placeholder="Current Password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label text-black">New Password<span style="color:red;">*</span>:</label>
                                    <input type="password" class="form-control" id="newPassword" placeholder="New Password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label text-black">Confirm Password<span style="color:red;">*</span>:</label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
                                </div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- profile modify details -->
    <div wire:ignore.self class="modal fade" id="modifyModalDetails" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabelDetails" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modifyModalLabelDetails">Modify Profile Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <fieldset>
                        <!-- Full Name -->
                        <form wire:submit.prevent="save_profile('modifyModalDetails')">
                            <div class="form-group row mb-2">
                                <label  class="col-sm-4 col-form-label">First name<span style="color:red;">*</span> :</label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" wire:model="profile_details.first_name" placeholder="Enter firstname" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-4 col-form-label">Middle name<span style="color:red;"></span> :</label>
                                <div class="col-sm-8">
                                <input type="text"  class="form-control" wire:model="profile_details.middle_name" placeholder="Enter middlename" >
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-4 col-form-label">Last name<span style="color:red;">*</span> :</label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" wire:model="profile_details.last_name" placeholder="Enter lastname" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

