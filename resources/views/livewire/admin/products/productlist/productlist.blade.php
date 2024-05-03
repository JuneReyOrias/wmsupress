<div>
    <!-- Page Content -->
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card border rounded">
                    
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Product Information</h3>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-4">
                            <button type="button" class="btn btn-success me-2" wire:click="add_product_default('addModalToggler')"> 
                                Add Product
                            </button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#addModal" id="addModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#editModal" id="editModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#activateModal" id="activateModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#deactivateModal" id="deactivateModalToggler" style="display:none">Add</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered text-black">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Image</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @forelse ($products_data  as $key => $value )
                                        <tr>
                                            <th scope="row" class="align-middle">{{(intval($products_data->currentPage()-1)*$products_data->perPage())+$key+1 }}</th>
                                            <td class="text-center">
                                                <img src="{{asset('storage/content/products/'.$value->image)}}" alt="Product Image"  style="object-fit: cover;width:150px height: 150px;">
                                            </td>
                                            <td>{{$value->code}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->description}}</td>
                                            <td>{{$value->price}}</td>
                                            <td>@if($value->is_active) Available @else Unavailable @endif</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"  wire:click="edit({{$value->id}},'editModalToggler')">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
                                                @if($value->is_active)
                                                    <button class="btn btn-danger btn-sm" wire:click="edit({{$value->id}},'deactivateModalToggler')">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Deactivate
                                                    </button>
                                                @else 
                                                    <button class="btn btn-warning btn-sm" wire:click="edit({{$value->id}},'activateModalToggler')">
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
                    </div>
                    <div class="pagination-container mt-3">
                        <ul class="pagination">
                            <li><a href="{{ $products_data->previousPageUrl() }}">Previous</a></li>
                            @foreach ($products_data->getUrlRange(1, $products_data->lastPage()) as $page => $url)
                                <li class="{{ $page == $products_data->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            <li><a href="{{ $products_data->nextPageUrl() }}">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: white; color: black;">
                <form wire:submit.prevent="save_add_product('addModalToggler')">

                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="addModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="product_image" class="form-label text-black">Product Image</label>
                            <div class="input-group" style="border: 1px solid black;padding: 6px ;border-radius: 5px;">
                                <div class="custom-file">
                                    <input type="file" wire:model="product.image" class="custom-file-input" id="product_image" name="product_image" accept=".jpg,.png" required>
                                </div>
                            </div>
                        </div> 
                        <div class="mb-2">
                            <label for="product_code" class="form-label text-black">Product Code</label>
                            <input type="text"  wire:model="product.code" class="form-control" id="product_code" name="product_code" placeholder="Product code" required>
                        </div>
                        <div class="mb-2">
                            <label for="product_name" class="form-label text-black">Product Name</label>
                            <input type="text" wire:model="product.name" class="form-control" id="product_name" name="product_name" placeholder="Product name"  required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label text-black">Product Price:</label>
                            <input type="number" min="0.01" step="0.01" class="form-control"  wire:model="product.price" id="productPrice" name="productPrice" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label text-black">Description</label>
                            <textarea class="form-control" wire:model="product.description" id="description" name="description" placeholder="Product description" rows="3"></textarea>
                        </div>
                        @if($product['error'])
                        <div class="col-md-12 mx-3">
                            <p style ="color:red">Error: {{$product['error']}}</p>
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

    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: white; color: black;">
                <form wire:submit.prevent="save_edit_product({{$product['id']}},'editModalToggler')">

                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="editModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="product_image" class="form-label text-black">Product Image</label>
                            <div class="input-group" style="border: 1px solid black;padding: 6px ;border-radius: 5px;">
                                <div class="custom-file">
                                    <input type="file" wire:model="product.image" class="custom-file-input" id="product_image" name="product_image" accept=".jpg,.png" required>
                                </div>
                            </div>
                        </div> 
                        <div class="mb-2">
                            <label for="product_code" class="form-label text-black">Product Code</label>
                            <input type="text"  wire:model="product.code" class="form-control" id="product_code" name="product_code" placeholder="Product code" required>
                        </div>
                        <div class="mb-2">
                            <label for="product_name" class="form-label text-black">Product Name</label>
                            <input type="text" wire:model="product.name" class="form-control" id="product_name" name="product_name" placeholder="Product name"  required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label text-black">Product Price:</label>
                            <input type="number" min="0.01" step="0.01" class="form-control"  wire:model="product.price" id="productPrice" name="productPrice" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label text-black">Description</label>
                            <textarea class="form-control" wire:model="product.description" id="description" name="description" placeholder="Product description" rows="3"></textarea>
                        </div>
                        @if($product['error'])
                        <div class="col-md-12 mx-3">
                            <p style ="color:red">Error: {{$product['error']}}</p>
                        </div>
                    @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_activate_product({{$product['id']}},'activateModalToggler')">
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
                <form wire:submit.prevent="save_deactivate_product({{$product['id']}},'deactivateModalToggler')">
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
