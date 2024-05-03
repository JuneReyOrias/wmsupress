<div>
    <!-- Page Content -->
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card border rounded">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Product Sizes</h3>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-4">
                            <button href="#" class="btn btn-success me-md-2" wire:click="add_size_default('addsizeModalToggler')">
                                Add
                            </button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#addsizeModal" id="addsizeModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#editsizeModal" id="editsizeModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#deactivatesizeModal" id="DeactivateModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#activatesizeModal" id="ActivateModalToggler" style="display:none">Add</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered text-black">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Size</th>
                                        <th>Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @forelse ($sizes_data  as $key => $value )
                                        <tr>
                                            <th scope="row" class="align-middle">{{(intval($sizes_data->currentPage()-1)*$sizes_data->perPage())+$key+1 }}</th>
                                            <td class="align-middle">{{$value->name}}</td>
                                            <td class="align-middle">{{$value->description}}</td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-primary btn-sm" wire:click="edit({{$value->id}},'editsizeModalToggler')">
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
                                <li><a href="{{ $sizes_data->previousPageUrl() }}">Previous</a></li>
                                @foreach ($sizes_data->getUrlRange(1, $sizes_data->lastPage()) as $page => $url)
                                    <li class="{{ $page == $sizes_data->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $sizes_data->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div wire:ignore.self class="modal fade" id="addsizeModal" tabindex="-1" aria-labelledby="addsizeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-size: white; size: black;">
                <form wire:submit.prevent="save_add_size('addsizeModalToggler')">

                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="addsizeModalLabel">Add Product size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body bg-white">
                        <div class="mb-2">
                            <label for="product_name" class="form-label text-black">Size Name</label>
                            <input type="text" wire:model="product_size.name" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label text-black">Size Description</label>
                            <textarea class="form-control" wire:model="product_size.description" required id="description" name="description" rows="3" ></textarea>
                        </div>
                    </div>
                    @if($product_size['error'])
                        <div class="col-md-12 mx-3">
                            <p style ="size:red">Error: {{$product_size['error']}}</p>
                        </div>
                    @endif
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div wire:ignore.self class="modal fade" id="editsizeModal" tabindex="-1" aria-labelledby="editsizeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_edit_size({{$product_size['id']}},'editsizeModalToggler')">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="editsizeModalLabel">Edit Product size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body bg-white">
                        <div class="mb-2">
                            <label for="product_name" class="form-label text-black">size Name</label>
                            <input type="text" wire:model="product_size.name" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label text-black">size Description</label>
                            <textarea class="form-control" wire:model="product_size.description" required id="description" name="description" rows="3" ></textarea>
                        </div>
                    </div>
                    @if($product_size['error'])
                        <div class="col-md-12 mx-3">
                            <p style ="size:red">Error: {{$product_size['error']}}</p>
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
    <div wire:ignore.self class="modal fade" id="activatesizeModal" tabindex="-1" aria-labelledby="activatesizeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_activate_size({{$product_size['id']}},'ActivateModalToggler')">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="activatesizeModalLabel">Activate</h5>
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

    <div wire:ignore.self class="modal fade" id="deactivatesizeModal" tabindex="-1" aria-labelledby="deactivatesizeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_deactivate_size({{$product_size['id']}},'DeactivateModalToggler')">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="deactivatesizeModalLabel">Deactivate</h5>
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
