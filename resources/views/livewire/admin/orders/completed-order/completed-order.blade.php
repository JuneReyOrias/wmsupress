
<div>

    <div class="page-content">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-md-15"> 
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="text-center">Completed Orders</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 justify-content-end">
                                <div class="col-auto">
                                    <label for="stockTypeFilter" class="form-label">Filter:</label>
                                </div>
                        
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-lg text-black"> 
                                    <thead>
                                        <tr>
                                            <th style="width:20%">Track No.</th>
                                            <th style="width:12%">Account Name</th>
                                            <th style="width:12%" class="text-center">Status</th>
                                            <th style="width:12%" class="">Price</th>
                                            <th style="width:12%" class="align-middle text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customer_order as $key =>$value)
                                        <tr>
                                            <td data-th="Price" class="align-middle">{{str_pad($value->id, 8, '0', STR_PAD_LEFT)}}</td>
                                            <td data-th="Price" class="align-middle">{{$value->first_name.' '.$value->middle_name.' '.$value->last_name}}</td>
                                            <td data-th="Price" class="align-middle text-center">{{$value->order_status}}</td>
                                            <td data-th="Price" class="align-middle ">PHP {{number_format($value->total_price, 2, '.', ',')}}</td>
                                            <td class="align-middle text-center">
                                                <button class="btn btn-primary btn-sm" wire:click="view_order({{$value->id}},'viewModalToggler')">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> View Order
                                                </button>
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
                                    <li><a href="{{ $customer_order->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($customer_order->getUrlRange(1, $customer_order->lastPage()) as $page => $url)
                                        <li class="{{ $page == $customer_order->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                    <li><a href="{{ $customer_order->nextPageUrl() }}">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#viewModal" id="viewModalToggler" style="display:none">Add</button>
    <div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="viewModalLabel">Order Details</h5>
                    <button type="button" class="close text-light" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-white text-black" id="to_print">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center mb-4">
                            <div class="col-6 col-md-3 text-center">
                                <img  src="{{url('landingpage')}}/assets/images/wmsu.png" alt="University Logo" style="max-width: 100px;max-height: 100px;">
                            </div>
                            <div class="col-6 col-md-3 text-center">
                                <span>Western Mindanao State University</span><br>
                                <h5>UNIVERSITY PRESS</h5>
                                <span>Zamboanga City</span>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                                <img  src="{{url('assets')}}/logo/upress-logo.png" alt="University Logo" style="max-width: 100px;max-height: 100px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="mb-2">
                                    <p><strong>Order ID:</strong> @if($order_details['customer_order']) {{str_pad($order_details['customer_order']->id, 8, '0', STR_PAD_LEFT)}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Order Status:</strong> @if($order_details['customer_order']) {{$order_details['customer_order']->order_status}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Customer Name:</strong> @if($order_details['customer_order']){{$order_details['customer_order']->first_name.' '.$order_details['customer_order']->middle_name.' '.$order_details['customer_order']->last_name}}@endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>College:</strong>@if($order_details['customer_order']) {{$order_details['customer_order']->college_name}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Department :</strong>@if($order_details['customer_order']) {{$order_details['customer_order']->department_name}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Order Date :</strong>@if($order_details['customer_order']) {{date_format(date_create($order_details['customer_order']->date_created),"M d, Y h:i a")}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Total Amount:</strong> @if($order_details['customer_order']) {{number_format($order_details['customer_order']->total_price, 2, '.', ',')}} @endif</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="" class="table border border-dark">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center">Image</th>
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>Product Size</th>
                                            <th>Product Color</th>
                                            <th>Product Qty</th>
                                            <th>Order Qty</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $total = 0;
                                            $valid_cart = true;
                                        ?>
                                        @forelse($order_details['order_items']  as $key => $value )
                                        <tr >
                                            <th scope="row" class="align-middle">{{$key+1 }}</th>
                                            <td class="text-center align-middle">
                                                <img src="{{asset('storage/content/products/'.$value->product_image)}}" alt="Product Image"  style="object-fit: cover;width:150px; height: 150px;">
                                            </td>
                                            <td class="align-middle">{{$value->product_code}}</td>
                                            <td class="align-middle">{{$value->product_name}}</td>
                                            <td class="align-middle">{{$value->product_size}}</td>
                                            <td class="align-middle">{{$value->product_color}}</td>
                                            <td class="align-middle">{{$value->product_quantity}}</td>
                                            <td class="align-middle">
                                               {{$value->quantity}}
                                            </td>
                                            <td class="align-middle">{{$value->product_price}}</td>
                                        </tr>
                                        <?php $total += ($value->quantity *$value->product_price)?>
                                        @empty
                                            <tr>
                                                <td colspan="42" class="text-center text-dark">NO DATA</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <img src="@if(isset($order_details['image_proof'])){{asset('storage/content/orders/proof/'.$order_details['image_proof'])}} @endif" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer bg-white text-black">
                    <a href="#"  onclick="print_this('to_print')" class="btn btn-secondary">Print</a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div> 

</div>

