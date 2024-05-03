
<div>

    <div class="page-content">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-md-15"> 
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="text-center">Product Orders</h3>
                        </div>
                        <div class="card-body">
                        <div class="row mb-3 justify-content-end">
                            <div class="col-auto">
                                    <label for="stockTypeFilter" class="form-label">Filter:</label>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select form-select-sm" id="stockTypeFilter" wire:model.live.debounce.250ms="filters.status_id">
                                        <option value="">All</option>
                                        @foreach($order_status as $key =>$value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-lg text-black"> 
                                    <thead>
                                        <tr>
                                            <th style="width:20%">Track No.</th>
                                            <th style="width:12%">Account Name</th>
                                            <th style="width:12%" class="text-center">Status</th>
                                            <th style="width:12%" class="align-middle text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customer_order as $key =>$value)
                                        <tr>
                                            <td data-th="Price" class="align-middle">{{str_pad($value->id, 8, '0', STR_PAD_LEFT)}}</td>
                                            <td data-th="Price" class="align-middle">{{$value->first_name.' '.$value->middle_name.' '.$value->last_name}}</td>
                                            <td data-th="Price" class="align-middle text-center">{{$value->order_status}}</td>
                                            <td class="align-middle text-center">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> View
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

    <!-- View Transaction Modal -->
    <!-- <div class="modal fade" id="viewTransactionModal" tabindex="-1" role="dialog" aria-labelledby="viewTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="viewTransactionModalLabel">Transaction Details</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

           
                <div class="modal-body bg-white text-black">
                    <div class="container-fluid">
                  
                    <div class="row justify-content-center align-items-center mb-4">
                  
                        <div class="col-6 col-md-3 text-center">
                            <img class="img-fluid rounded-circle mb-2" src="../landingpage/assets/images/wmsu.png" alt="University Logo" style="max-width: 100px;">
                        </div>

                      
                        <div class="col-6 col-md-3 text-center">
                            <span>Western Mindanao State University</span><br>
                            <h5>UNIVERSITY PRESS</h5>
                            <span>Zamboanga City</span>
                        </div>

                      
                        <div class="col-6 col-md-3 text-center">
                            <img class="img-fluid rounded-circle mb-2" src="../assets/logo/upress-logo.png" alt="University Logo" style="max-width: 100px;">
                        </div>
                    </div>

                     
                        <div class="row">
              
                            <div class="col-md-6 mt-3">
                                <div class="mb-2">
                                    <p><strong>Order ID:</strong> 1</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Customer Name:</strong> John Doe</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>College:</strong>College of Computing Studies</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Department :</strong>Computer Science</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Product:</strong> Lanyard (Red, Large)</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Unit Price:</strong> 300</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Quantity:</strong> 3</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Total Amount:</strong> 900</p>
                                </div>
                            </div>

                         
                            <div class="col-md-6 text-center">
                                <div class="mb-0">
                                    <p><strong>Payment Proof:</strong></p>
                                    <img src="https://via.placeholder.com/300" class="img-fluid" alt="Payment Proof">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            
                <div class="modal-footer bg-white text-black">
                      <a href="#"  onclick="print_this('to_print')" class="btn btn-secondary">Print</a>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div> -->

</div>

