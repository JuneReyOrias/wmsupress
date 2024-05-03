<div>
    <!-- Page Content -->
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card border rounded">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Departments list @if($college['name']){{'of '.$college['name']}}@endif</h3>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-4">
                            <div class="col-1 mx-2">
                                <select name="" id="" class="form-select" wire:model="college_id" wire:change="redirect_college_department()">
                                    <option value="departments">
                                        All Departments
                                    </option>
                                    @foreach($colleges_data as $key => $value)
                                        <option value="{{ $value->id}}">
                                            {{$value->code}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button href="#" class="btn btn-success me-md-2" wire:click="add_department_default('addModalToggler')">
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
                                    @forelse ($departments_data  as $key => $value )
                                        <tr>
                                            <th scope="row" class="align-middle">{{(intval($departments_data->currentPage()-1)*$departments_data->perPage())+$key+1 }}</th>
                                            <td class="align-middle">{{$value->code}}</td>
                                            <td class="align-middle">{{$value->name}}</td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-primary btn-sm" wire:click="edit({{$value->id}},'editModalToggler')">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
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
                                <li><a href="{{ $departments_data->previousPageUrl() }}">Previous</a></li>
                                @foreach ($departments_data->getUrlRange(1, $departments_data->lastPage()) as $page => $url)
                                    <li class="{{ $page == $departments_data->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $departments_data->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-department: white; department: black;">
                <form wire:submit.prevent="save_add_department('addModalToggler')">

                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="addModalLabel">Add Department @if($college['name']){{'to '.$college['code']}} @endif</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-dark bg-white">
                        <select name="" id="" class="form-select" wire:model.live="college_id" >
                            <option value="departments">
                                Select Department
                            </option>
                            @foreach($colleges_data as $key => $value)
                                <option value="{{ $value->id}}">
                                    {{$value->code}}
                                </option>
                            @endforeach
                        </select>
                        <div class="mb-2">
                            <label for="code" class="form-label text-black"> Code</label>
                            <input type="text" wire:model="department.code" class="form-control" id="code" code="code" placeholder="Enter code" required>
                        </div>
                        <div class="mb-2">
                            <label for="name" class="form-label text-black"> name</label>
                            <textarea class="form-control" wire:model="department.name" id="name" code="name" rows="3" placeholder="Enter name" required ></textarea>
                        </div>
                    </div>
                    @if($department['error'])
                        <div class="col-md-12 mx-3 bg-white">
                            <p style ="color:red;background-color:#fff">Error: {{$department['error']}}</p>
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
                <form wire:submit.prevent="save_edit_department({{$department['id']}},'editModalToggler')">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="editModalLabel">Edit Department @if($college['code']){{'from '.$college['code']}}@endif </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-dark bg-white">
                        <div class="mb-2">
                            <label for="code" class="form-label text-black"> Code</label>
                            <input type="text" wire:model="department.code" class="form-control" id="code" code="code" placeholder="Enter code" required>
                        </div>
                        <div class="mb-2">
                            <label for="name" class="form-label text-black"> name</label>
                            <textarea class="form-control" wire:model="department.name" id="name" code="name" rows="3" placeholder="Enter name" required ></textarea>
                        </div>
                    </div>
                    @if($department['error'])
                        <div class="col-md-12 mx-3 bg-white">
                            <p style ="color:red">Error: {{$department['error']}}</p>
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
                <form wire:submit.prevent="save_activate_department({{$department['id']}},'ActivateModalToggler')">
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
                <form wire:submit.prevent="save_deactivate_department({{$department['id']}},'DeactivateModalToggler')">
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
