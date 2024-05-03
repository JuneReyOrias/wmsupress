<div>
    <!-- Page Content -->
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card border rounded">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">College </h3>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-4">
                            <button href="#" class="btn btn-success me-md-2" wire:click="add_college_default('addModalToggler')">
                                Add
                            </button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#addModal" id="addModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#editModal" id="editModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#deactivateModal" id="DeactivateModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#activateModal" id="ActivateModalToggler" style="display:none">Add</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered text-black">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>code</th>
                                        <th>name</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @forelse ($colleges_data  as $key => $value )
                                        <tr>
                                            <th scope="row" class="align-middle">{{(intval($colleges_data->currentPage()-1)*$colleges_data->perPage())+$key+1 }}</th>
                                            <td class="align-middle">{{$value->code}}</td>
                                            <td class="align-middle">{{$value->name}}</td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-primary btn-sm" wire:click="edit({{$value->id}},'editModalToggler')">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
                                                <a href="{{route('admin-colleges').'/'.$value->id}}">
                                                    <button type="button" class="btn btn-primary btn-sm" >
                                                        <i class="fas fa-pencil-alt"></i> Edit Departments
                                                    </button>
                                                </a>
                                                @if($value->is_active)
                                                    <button class="btn btn-danger btn-sm" wire:click="edit({{$value->id}},'DeactivateModalToggler')">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Deactivate
                                                    </button>
                                                @else 
                                                    <button class="btn btn-warning btn-sm" wire:click="edit({{$value->id}},'ActivateModalToggler')">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Activate
                                                    </button>
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
                        
                        <!-- Pagination -->
                        <div class="pagination-container mt-3">
                            <ul class="pagination">
                                <li><a href="{{ $colleges_data->previousPageUrl() }}">Previous</a></li>
                                @foreach ($colleges_data->getUrlRange(1, $colleges_data->lastPage()) as $page => $url)
                                    <li class="{{ $page == $colleges_data->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $colleges_data->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add College Modal -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-college: white; college: black;">
                <form wire:submit.prevent="save_add_college('addModalToggler')">

                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="addModalLabel">Add College </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-dark bg-white">
                        <div class="mb-2">
                            <label for="code" class="form-label text-black"> Code</label>
                            <input type="text" wire:model="college.code" class="form-control" id="code" code="code" placeholder="Enter code" required>
                        </div>
                        <div class="mb-2">
                            <label for="name" class="form-label text-black"> name</label>
                            <textarea class="form-control" wire:model="college.name" id="name" code="name" rows="3" placeholder="Enter name" required ></textarea>
                        </div>
                    </div>
                    @if($college['error'])
                        <div class="col-md-12 mx-3 bg-white">
                            <p style ="color:red;background-color:#fff">Error: {{$college['error']}}</p>
                        </div>
                    @endif
                    <div class="modal-footer text-dark bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_edit_college({{$college['id']}},'editModalToggler')">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="editModalLabel">Edit College </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-dark bg-white">
                        <div class="mb-2">
                            <label for="code" class="form-label text-black"> Code</label>
                            <input type="text" wire:model="college.code" class="form-control" id="code" code="code" placeholder="Enter code" required>
                        </div>
                        <div class="mb-2">
                            <label for="name" class="form-label text-black"> name</label>
                            <textarea class="form-control" wire:model="college.name" id="name" code="name" rows="3" placeholder="Enter name" required ></textarea>
                        </div>
                    </div>
                    @if($college['error'])
                        <div class="col-md-12 mx-3 bg-white">
                            <p style ="color:red">Error: {{$college['error']}}</p>
                        </div>
                    @endif
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_activate_college({{$college['id']}},'ActivateModalToggler')">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="activateModalLabel">Activate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="col-md-12 text-center">
                            <p class="text-center text-warning">Are you sure you want to activate this?</p>
                        </div>
                    </div>
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_deactivate_college({{$college['id']}},'DeactivateModalToggler')">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="deactivateModalLabel">Deactivate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="col-md-12 text-center">
                            <p class="text-danger text-center">Are you sure you want to deactivate this?</p>
                        </div>
                    </div>
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
