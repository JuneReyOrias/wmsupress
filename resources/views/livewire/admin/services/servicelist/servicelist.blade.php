<div>
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card border rounded">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Service List</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-2">
                            <button type="button" class="btn btn-success float-end mb-2" wire:click="add_service_default('addModalToggler')">
                                Add Service
                            </button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#addModal" id="addModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#editModal" id="editModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#deactivateModal" id="deactivateModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#activateModal" id="activateModalToggler" style="display:none">Add</button>
                
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-black text-black">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th class="align-middle text-center">Image</th>
                                        <th  class="align-middle">Service Name</th>
                                        <th  class="align-middle">Service Description</th>
                                        <th  class="align-middle text-center">Status</th>
                                        <th  class="align-middle text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($service_data  as $key => $value )
                                        <tr>
                                            <th scope="row" class="align-middle">{{(intval($service_data->currentPage()-1)*$service_data->perPage())+$key+1 }}</th>
                                                <td class="text-center">
                                                    <img src="{{asset('storage/content/services/'.$value->image)}}" alt="Product Image"  style="object-fit: cover;width:150px height: 150px;">
                                                </td>
                                            <td class="align-middle">{{$value->name}}</td>
                                            <td  class="align-middle">{{$value->description}}</td>
                                            <td class="align-middle text-center">@if($value->is_active) Available @else Unavailable @endif</td>
                                            <td class="align-middle text-center">
                                                <button type="button" class="btn btn-primary" wire:click="edit_service({{$value->id}},'editModalToggler')">
                                                    Edit
                                                </button>
                                                @if($value->is_active) 
                                                    <button type="button" class="btn btn-danger" wire:click="edit_service({{$value->id}},'deactivateModalToggler')">
                                                        Deactivate
                                                    </button>
                                                @else 
                                                    <button type="button" class="btn btn-warning" wire:click="edit_service({{$value->id}},'activateModalToggler')">
                                                        Activate
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
                        <div class="pagination-container mt-3">
                            <ul class="pagination">
                                <li><a href="{{ $service_data->previousPageUrl() }}">Previous</a></li>
                                @foreach ($service_data->getUrlRange(1, $service_data->lastPage()) as $page => $url)
                                    <li class="{{ $page == $service_data->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $service_data->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="addModalLabel">Add Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save_add_service('addModalToggler')">
                <div class="modal-body bg-white text-black">
                        <div class="mb-2">
                            <label for="service_image" class="form-label text-black">Service Image</label>
                            <div class="input-group" style="border: 1px solid black;padding: 6px ;border-radius: 5px;">
                                <div class="custom-file">
                                    <input type="file" wire:model="service.image" class="custom-file-input" id="service_image" name="service_image" accept=".jpg,.png" required>
                                </div>
                            </div>
                        </div> 
                        <div class="mb-2">
                            <label for="service_name" class="form-label text-black">Service Name</label>
                            <input type="text" wire:model="service.name" class="form-control" id="service_name" name="service_name" placeholder="Service name"  required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label text-black">Description</label>
                            <textarea class="form-control" wire:model="service.description" id="description" name="description" placeholder="Service description" rows="3"></textarea>
                        </div>
                        @if($service['error'])
                            <div class="col-md-12 mx-3">
                                <p style ="color:red">Error: {{$service['error']}}</p>
                            </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="editModalLabel">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save_edit_service({{$service['id']}},'editModalToggler')">
                    <div class="modal-body bg-white text-black">
                        <div class="mb-2">
                            <label for="service_image" class="form-label text-black">Service Image</label>
                            <div class="input-group" style="border: 1px solid black;padding: 6px ;border-radius: 5px;">
                                <div class="custom-file">
                                    <input type="file" wire:model="service.image" class="custom-file-input" id="service_image" name="service_image" accept=".jpg,.png" >
                                </div>
                            </div>
                        </div> 
                        <div class="mb-2">
                            <label for="service_name" class="form-label text-black">Service Name</label>
                            <input type="text" wire:model="service.name" class="form-control" id="service_name" name="service_name" placeholder="Service name"  required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label text-black">Description</label>
                            <textarea class="form-control" wire:model="service.description" id="description" name="description" placeholder="Service description" rows="3"></textarea>
                        </div>
                        @if($service['error'])
                            <div class="col-md-12 mx-3">
                                <p style ="color:red">Error: {{$service['error']}}</p>
                            </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_activate_service({{$service['id']}},'activateModalToggler')">
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
                        <button type="submit" class="btn btn-warning">Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_deactivate_service({{$service['id']}},'deactivateModalToggler')">
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
                        <button type="submit" class="btn btn-danger">Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
