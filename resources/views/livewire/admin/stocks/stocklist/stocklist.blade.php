<div>
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card border rounded">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Product Stocks</h3>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-4">
                            <button type="button" class="btn btn-success me-2" wire:click="add_product_stock_default('addModalToggler')"> 
                                Add New Stock
                            </button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#addModal" id="addModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#editModal" id="editModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#activateModal" id="activateModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#deactivateModal" id="deactivateModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#StockInModal" id="StockInModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#StockOutModal" id="StockOutModalToggler" style="display:none">Add</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Image</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Product Size</th>
                                        <th>Product Color</th>
                                        <th>Product Qty</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @forelse ($stocks_data  as $key => $value )
                                        <tr>
                                            <th scope="row" class="align-middle">{{(intval($stocks_data->currentPage()-1)*$stocks_data->perPage())+$key+1 }}</th>
                                            <td class="text-center align-middle">
                                                <img src="{{asset('storage/content/products/'.$value->product_image)}}" alt="Product Image"  style="object-fit: cover;width:150px height: 150px;">
                                            </td>
                                            <td class="align-middle">{{$value->product_code}}</td>
                                            <td class="align-middle">{{$value->product_name}}</td>
                                            <td class="align-middle">{{$value->product_size}}</td>
                                            <td class="align-middle">{{$value->product_color}}</td>
                                            <td class="align-middle">{{$value->product_quantity}}</td>
                                            <td class="align-middle text-center">@if($value->is_active) Available @else Unavailable @endif</td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-primary btn-sm"  wire:click="edit({{$value->id}},'editModalToggler')">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
                                                @if($value->is_active)
                                                  
                                                    <button class="btn btn-warning btn-sm" wire:click="edit({{$value->id}},'StockInModalToggler')">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Stock-In
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" wire:click="edit({{$value->id}},'StockOutModalToggler')">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Stock-Out
                                                    </button>
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
                        <div class="pagination-container mt-3">
                            <ul class="pagination">
                                <li><a href="{{ $stocks_data->previousPageUrl() }}">Previous</a></li>
                                @foreach ($stocks_data->getUrlRange(1, $stocks_data->lastPage()) as $page => $url)
                                    <li class="{{ $page == $stocks_data->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $stocks_data->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add stock modal -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="addModalLabel">Add New Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white text-black">
                    <form wire:submit.prevent="add_new_stock('addModalToggler')">
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Product:</label>
                            <select class="form-select"  wire:model="product_stock.product_id" wire:change="update_product_details()" name="role" required id="role" aria-label="Select Role">
                                <option selected value="">Select Product</option>    
                                @foreach($products as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Size:</label>
                            <select class="form-select"  wire:model="product_stock.product_size_id" wire:change="update_product_size_details()" name="role" required id="role" aria-label="Select Role">
                                <option selected value="">Select Size</option>    
                                @foreach($product_sizes as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sizeName" class="form-label text-black">Size Name:</label>
                            <input type="text"  wire:model="product_stock.product_size" class="form-control bg-white" id="sizeName" name="sizeName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Color:</label>
                            <select class="form-select"  wire:model="product_stock.product_color_id" name="role" required id="role" aria-label="Select Role">
                                <option selected value="">Select Color</option>    
                                @foreach($product_colors as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Product Code:</label>
                            <input type="text"  wire:model="product_stock.product_code" class="form-control bg-white" id="productCode" name="productCode" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="form-label text-black">Product Name:</label>
                            <input type="text"  wire:model="product_stock.product_name" class="form-control bg-white" id="productName" name="productName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label text-black">Quantity:</label>
                            <input type="number" min="1" max="1000" step="1" wire:model="product_stock.product_quantity" class="form-control bg-white" id="quantity" name="quantity" required>
                        </div>
                        @if($product_stock['error'])
                        <div class="col-md-12 mx-3">
                            <p style ="color:red">Error: {{$product_stock['error']}}</p>
                        </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Stock</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="editModalLabel">Edit Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white text-black">
                    <form wire:submit.prevent="save_edit_stock({{$product_stock['id']}},'editModalToggler')">
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Product:</label>
                            <select class="form-select"  wire:model="product_stock.product_id" wire:change="update_product_details()" name="role" required id="role" aria-label="Select Role">
                                <option selected value="">Select Product</option>    
                                @foreach($products as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Size:</label>
                            <select class="form-select"  wire:model="product_stock.product_size_id" wire:change="update_product_size_details()" name="role" required id="role" aria-label="Select Role">
                                <option selected value="">Select Size</option>    
                                @foreach($product_sizes as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sizeName" class="form-label text-black">Size Name:</label>
                            <input type="text"  wire:model="product_stock.product_size" class="form-control bg-white" id="sizeName" name="sizeName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Color:</label>
                            <select class="form-select"  wire:model="product_stock.product_color_id" name="role" required id="role" aria-label="Select Role">
                                <option selected value="">Select Color</option>    
                                @foreach($product_colors as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Product Code:</label>
                            <input type="text"  wire:model="product_stock.product_code" class="form-control bg-white" id="productCode" name="productCode" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="form-label text-black">Product Name:</label>
                            <input type="text"  wire:model="product_stock.product_name" class="form-control bg-white" id="productName" name="productName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label text-black">Quantity:</label>
                            <input disabled type="number" min="1" max="1000" step="1" wire:model="product_stock.product_quantity" class="form-control bg-white" id="quantity" name="quantity" required>
                        </div>
                        @if($product_stock['error'])
                        <div class="col-md-12 mx-3">
                            <p style ="color:red">Error: {{$product_stock['error']}}</p>
                        </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="StockInModal" tabindex="-1" aria-labelledby="StockInModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="StockInModalLabel">Stock In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white text-black">
                    <form wire:submit.prevent="save_stock_in({{$product_stock['id']}},'StockInModalToggler')">
                        <div class="mb-3">
                            <label for="sizeName" class="form-label text-black">Size Name:</label>
                            <input type="text"  wire:model="product_stock.product_size" class="form-control bg-white" id="sizeName" name="sizeName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Color:</label>
                            <select class="form-select"  wire:model="product_stock.product_color_id" name="role" required id="role" aria-label="Select Role" disabled>
                                <option selected value="">Select Color</option>    
                                @foreach($product_colors as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Product Code:</label>
                            <input type="text"  wire:model="product_stock.product_code" class="form-control bg-white" id="productCode" name="productCode" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="form-label text-black">Product Name:</label>
                            <input type="text"  wire:model="product_stock.product_name" class="form-control bg-white" id="productName" name="productName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label text-black">Quantity:</label>
                            <input  type="number" min="{{$product_stock['product_quantity']}}" max="1000" step="1" wire:model="product_stock.product_quantity" class="form-control bg-white" id="quantity" name="quantity" required>
                        </div>
                        @if($product_stock['error'])
                        <div class="col-md-12 mx-3">
                            <p style ="color:red">Error: {{$product_stock['error']}}</p>
                        </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="StockOutModal" tabindex="-1" aria-labelledby="StockOutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="StockOutModalLabel">Stock Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white text-black">
                    <form wire:submit.prevent="save_stock_out({{$product_stock['id']}},'StockOutModalToggler')">
                        <div class="mb-3">
                            <label for="sizeName" class="form-label text-black">Size Name:</label>
                            <input type="text"  wire:model="product_stock.product_size" class="form-control bg-white" id="sizeName" name="sizeName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Color:</label>
                            <select class="form-select"  wire:model="product_stock.product_color_id" name="role" required id="role" aria-label="Select Role" disabled>
                                <option selected value="">Select Color</option>    
                                @foreach($product_colors as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCode" class="form-label text-black">Product Code:</label>
                            <input type="text"  wire:model="product_stock.product_code" class="form-control bg-white" id="productCode" name="productCode" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="form-label text-black">Product Name:</label>
                            <input type="text"  wire:model="product_stock.product_name" class="form-control bg-white" id="productName" name="productName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label text-black">Quantity:</label>
                            <input type="number" min="0" max="{{$product_stock['product_quantity']}}" step="1" wire:model="product_stock.product_quantity" class="form-control bg-white" id="quantity" name="quantity" required>
                        </div>
                        @if($product_stock['error'])
                        <div class="col-md-12 mx-3">
                            <p style ="color:red">Error: {{$product_stock['error']}}</p>
                        </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save_activate_product_stock({{$product_stock['id']}},'activateModalToggler')">
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
                <form wire:submit.prevent="save_deactivate_product_stock({{$product_stock['id']}},'deactivateModalToggler')">
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
