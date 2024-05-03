<div>
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center"> Admin Users</h3>
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                        <div class="alert alert-success" id="success-alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            {{ session()->get('message') }}
                        </div>
                        @endif
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="#" class="btn btn-success me-md-2" wire:click="add_user_default('addAccountModalToggler')">Add</a>
                        </div>
                        <br>
                        <div>
                            <div class="table-responsive tab" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border-radius: 10px;">
                                <table class="table table-info" >
                                    <thead class="thead-light">
                                        <tr>
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">#</th>
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">Image</th>
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">Email</th>
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">FirstName</th>
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">Middle Name</th>
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">LastName</th>
                                        <!-- <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">College</th>
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">Department</th> -->
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">Contact #</th>
                                        <th style="padding:20px; font-weight: bold; background-color: #343a40; color: white;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users_data  as $key => $value )
                                            <tr class="table-light">
                                                <th scope="row" class="px-4 py-3 align-middle">{{(intval($users_data->currentPage()-1)*$users_data->perPage())+$key+1 }}</th>
                                                <td class="align-middle">
                                                    <img style="height:100px; width:100px;" src="{{asset('storage/content/profile/'.$value->image) }}">
                                                </td>
                                                <td class="align-middle">{{ $value->email}}</td>
                                                 <td class="align-middle">{{ $value->first_name}}</td>
                                                 <td class="align-middle">{{ $value->middle_name}}</td>
                                                 <td class="align-middle">{{ $value->last_name}}</td>
                                                 <!-- <td class="align-middle">{{ $value->college_name }}</td>
                                                 <td class="align-middle">{{ $value->department_name}}</td> -->
                                                 <td class="align-middle">{{ $value->contact_no}}</td>
                                                 <td class="align-middle">
                                                    <a wire:click="edit_user({{$value->id}},'editAccountModalToggler')">
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>
                                                    @if($value->is_active)
                                                        <a  wire:click="edit_user({{$value->id}},'DeactivateAccountModalToggler')">
                                                            <button class="btn btn-danger btn-sm">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Deactivate
                                                            </button>
                                                        </a>
                                                    @else 
                                                        <a  wire:click="edit_user({{$value->id}},'ActivateAccountModalToggler')">
                                                            <button class="btn btn-warning btn-sm">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Activate
                                                            </button>
                                                        </a>
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="42" class="text-center text-dark">NO DATA</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#addAccountModal" id="addAccountModalToggler" style="display:none">Add</button>
                            <div wire:ignore.self class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg modal-dialog-centered"> 
                                    <div class="modal-content bg-maroon">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-white" id="addAccountModalLabel">Add Admin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-white text-black">
                                            <form wire:submit.prevent="add_user('addAccountModalToggler')">
                                                <input type="hidden" name="_token" value="giFBHnCrkDKLxxwYQxLNuY6iqeGUsJXXlDuUvbLR" autocomplete="off">                   
                                                 <div class="row g-3 mb-3"> 
                                                    <div class="col-md-6">
                                                        <label for="firstname" class="form-label text-dark">First Name:</label>
                                                        <input type="text"  wire:model="user.first_name" class="form-control " required name="firstname" id="firstname" placeholder="Enter firstname" value="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="firstname" class="form-label text-dark">Middle Name:</label>
                                                        <input type="text"  wire:model="user.middle_name" class="form-control " name="firstname" id="firstname" placeholder="Enter middlename" value="">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="lastname" class="form-label text-dark">Last Name:</label>
                                                        <input type="text"  wire:model="user.last_name" class="form-control " required name="lastname" id="lastname" placeholder="Enter lastname" value="">
                                                    </div>
                                               
                                                    <div class="col-md-6">
                                                        <label for="role" class="form-label text-dark">Role:</label>
                                                        <select class="form-select"  wire:model="user.role_id" name="role" required id="role" aria-label="Select Role">
                                                            @foreach($admin_roles as $key =>$value)
                                                            <option selected value="{{$value->id}}">{{$value->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="email" class="form-label text-dark">Email:</label>
                                                        <input type="text"  wire:model="user.email" class="form-control " required name="email" id="email" placeholder="Enter email" value="">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="contact_no" class="form-label text-dark">Contact No.:</label>
                                                        <input type="number"  wire:model="user.contact_no" class="form-control "  name="Contact #" id="" placeholder="Enter contact #" value="">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="password" class="form-label text-dark">Password:</label>
                                                        <input type="password"  wire:model="user.password" class="form-control " required name="password" id="password" placeholder="Enter your password">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="confirm_password" class="form-label text-dark">Confirm Password:</label>
                                                        <input type="password"  wire:model="user.confirm_password" class="form-control" required name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                                                    </div>
                                                    @if($user['error'])
                                                        <div class="col-md-12">
                                                            <p style ="color:red">Error: {{$user['error']}}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#editAccountModal" id="editAccountModalToggler" style="display:none">Add</button>
                            <div wire:ignore.self class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg modal-dialog-centered"> 
                                    <div class="modal-content bg-maroon">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-white" id="editAccountModalLabel">Edit Admin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-white text-black">
                                            <form wire:submit.prevent="save_edit_user({{$user['id']}},'editAccountModalToggler')">
                                                <input type="hidden" name="_token" value="giFBHnCrkDKLxxwYQxLNuY6iqeGUsJXXlDuUvbLR" autocomplete="off">                    
                                                <div class="row g-3"> 
                                                    <div class="col-md-6">
                                                        <label for="firstname" class="form-label">First Name:</label>
                                                        <input type="text"  wire:model="user.first_name" class="form-control " required name="firstname" id="firstname" placeholder="Enter firstname" value="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="firstname" class="form-label">Middle Name:</label>
                                                        <input type="text"  wire:model="user.middle_name" class="form-control " name="firstname" id="firstname" placeholder="Enter middlename" value="">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="lastname" class="form-label">Last Name:</label>
                                                        <input type="text"  wire:model="user.last_name" class="form-control " required name="lastname" id="lastname" placeholder="Enter lastname" value="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="role" class="form-label">Role:</label>
                                                        <select class="form-select"  wire:model="user.role_id" name="role" required id="role" aria-label="Select Role">
                                                            @foreach($admin_roles as $key =>$value)
                                                            <option selected value="{{$value->id}}">{{$value->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="email" class="form-label">Email:</label>
                                                        <input type="text" disabled wire:model="user.email" class="form-control " required name="email" id="email" placeholder="Enter email" value="">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="contact_no" class="form-label">Contact No.:</label>
                                                        <input type="number"  wire:model="user.contact_no" class="form-control "  name="Contact #" id="" placeholder="Enter contact #" value="">
                                                    </div>
                                                    @if($user['error'])
                                                        <div class="col-md-12">
                                                            <p style ="color:red">Error: {{$user['error']}}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#ActivateAccountModal" id="ActivateAccountModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#DeactivateAccountModal" id="DeactivateAccountModalToggler" style="display:none">Add</button>
                            <div wire:ignore.self class="modal fade" id="ActivateAccountModal" tabindex="-1" aria-labelledby="ActivateAccountModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg modal-dialog-centered"> 
                                    <div class="modal-content bg-maroon">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-white" id="ActivateAccountModalLabel">Activate</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-white text-black">
                                            <form wire:submit.prevent="save_activate_user({{$user['id']}},'ActivateAccountModalToggler')">
                                                <div class="col-md-12 text-center">
                                                    <p class="text-yellow text-center">Are you sure you want to activate this user?</p>
                                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div wire:ignore.self class="modal fade" id="DeactivateAccountModal" tabindex="-1" aria-labelledby="DeactivateAccountModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg modal-dialog-centered"> 
                                    <div class="modal-content bg-maroon">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-white" id="DeactivateAccountModalLabel">Activate</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-white text-black">
                                            <form wire:submit.prevent="save_deactivate_user({{$user['id']}},'DeactivateAccountModalToggler')">
                                                <div class="col-md-12 text-center">
                                                    <p class="text-red text-center">Are you sure you want to deactivate this user?</p>
                                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="pagination-container">
                        <ul class="pagination">
                            <li><a href="{{ $users_data->previousPageUrl() }}">Previous</a></li>
                            @foreach ($users_data->getUrlRange(1, $users_data->lastPage()) as $page => $url)
                                <li class="{{ $page == $users_data->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            <li><a href="{{ $users_data->nextPageUrl() }}">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
       
    </script>
</div>
