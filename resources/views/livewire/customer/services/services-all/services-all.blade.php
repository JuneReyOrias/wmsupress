<div>
    <div class="page-heading products-heading header-text" style="background-image: url('{{url('landingpage')}}/assets/images/products-heading.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>View</h4>
                        <h2>Services</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="products vh-100">
        <div class="container">
            @livewire('components.customer-service-filters.customer-service-filters')
            <div class="card card-body border rounded">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <article class="card">
                            <div class="card-body row">
                                <div class="col-12">
                                    <img class="rounded-circles d-block mx-auto mb-4" style="max-width: 200%; height: auto; max-height: 300px;" src="{{url('landingpage')}}/assets/images/wmsu.png" alt="University Logo">
                                    <div class="text-center">
                                        <span>Western Mindanao State University</span><br>
                                        <h5>UNIVERSITY PRESS</h5>
                                        <span>Zamboanga City</span>
                                    </div>
                                    <div class="text-center d-none d-md-block">
                                        <h5>SERVICE AVAIL SLIP</h5>
                                    </div>
                                    <div class="d-flex justify-content-md-between flex-column flex-md-row text-center">
                                        <div class="mb-md-0">
                                            <p>
                                                WMSU-UPRESS
                                            </p>
                                        </div>
                                        <div class="mb-md-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <div class="table-responsive">
                            <table id="shoppingCart" class="table-condensed table">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Track No.</th>
                                        <th style="width:12%">Account Name</th>
                                        <th style="width:12%" class="text-center">Status</th>
                                        <th style="width:12%" class="align-middle text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($availed_services as $key =>$value)
                                    <tr>
                                        <td data-th="Price" class="align-middle">Track No: {{str_pad($value->id, 8, '0', STR_PAD_LEFT)}}</td>
                                        <td data-th="Price" class="align-middle">{{$value->first_name.' '.$value->middle_name.' '.$value->last_name}}</td>
                                        <td data-th="Price" class="align-middle text-center">{{$value->service_status}}</td>
                                        <td class="align-middle text-center">
                                            @if($value->service_status_id == 4)
                                                <button class="btn btn-primary btn-sm" wire:click="view_availed_service({{$value->id}},'viewCompleteModalToggler')">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> View
                                                </button>
                                            @else 
                                                <button class="btn btn-primary btn-sm" wire:click="view_availed_service({{$value->id}},'viewModalToggler')">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> View
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
                                <li><a href="{{ $availed_services->previousPageUrl() }}">Previous</a></li>
                                @foreach ($availed_services->getUrlRange(1, $availed_services->lastPage()) as $page => $url)
                                    <li class="{{ $page == $availed_services->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $availed_services->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#viewModal" id="viewModalToggler" style="display:none">Add</button>
    <div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" >
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="viewModalLabel">Service Details</h5>
                    <button type="button" class="close text-light" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-white text-black" id="to_print">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center mb-4">
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
                            <div class="col-md-6 mt-3 text-start">
                                <div class="mb-2">
                                    <p><strong>Service ID:</strong> @if($service_availed['availed_services']) {{str_pad($service_availed['availed_services']->id, 8, '0', STR_PAD_LEFT)}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Service Status:</strong> @if($service_availed['availed_services']) {{$service_availed['availed_services']->service_status}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Customer Name:</strong> @if($service_availed['availed_services']){{$service_availed['availed_services']->first_name.' '.$service_availed['availed_services']->middle_name.' '.$service_availed['availed_services']->last_name}}@endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>College:</strong>@if($service_availed['availed_services']) {{$service_availed['availed_services']->college_name}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Department :</strong>@if($service_availed['availed_services']) {{$service_availed['availed_services']->department_name}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Avail Service Date :</strong>@if($service_availed['availed_services']) {{date_format(date_create($service_availed['availed_services']->date_created),"M d, Y h:i a")}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Total Amount:</strong> @if(isset($service_availed['availed_services']->total_price)) {{number_format($service_availed['availed_services']->total_price, 2, '.', ',')}} @endif</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="" class="table ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">Image</th>
                                                <th>Service Name</th>
                                                <th >Service Desc</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $total = 0;
                                                $valid_cart = true;
                                            ?>
                                            @forelse($service_availed['availed_service_items']  as $key => $value )
                                                <?php if(!$value->is_active) {$valid_cart = false;}?>
                                                <tr @if(!$value->is_active) class="bg-danger" @endif>
                                                    <th scope="row" class="align-middle">{{$key +1 }}</th>
                                                    <td class="text-center align-middle">
                                                        <img src="{{asset('storage/content/services/'.$value->service_image)}}" alt="Product Image"  style="object-fit: cover;width:100px; max-height: 100px;">
                                                    </td>
                                                    <td class="align-middle">{{$value->service_name}}</td>
                                                    <td class="align-middle">{{$value->service_description}}</td>
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
                    </div>
                    
                </div>
            
                <div class="modal-footer bg-white text-black">
                    <a href="#"  onclick="print_this('to_print')" class="btn btn-secondary">Print</a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div> 
    <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#viewCompleteModal" id="viewCompleteModalToggler" style="display:none">Add</button>
    <div wire:ignore.self class="modal fade" id="viewCompleteModal" tabindex="-1" role="dialog" aria-labelledby="viewCompleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" >
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="viewCompleteModalLabel">Service Details</h5>
                    <button type="button" class="close text-light" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-white text-black" id="to_print">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center mb-4">
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
                            <div class="col-md-6 mt-3 text-start">
                                <div class="mb-2">
                                    <p><strong>Service ID:</strong> @if($service_availed['availed_services']) {{str_pad($service_availed['availed_services']->id, 8, '0', STR_PAD_LEFT)}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Service Status:</strong> @if($service_availed['availed_services']) {{$service_availed['availed_services']->service_status}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Customer Name:</strong> @if($service_availed['availed_services']){{$service_availed['availed_services']->first_name.' '.$service_availed['availed_services']->middle_name.' '.$service_availed['availed_services']->last_name}}@endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>College:</strong>@if($service_availed['availed_services']) {{$service_availed['availed_services']->college_name}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Department :</strong>@if($service_availed['availed_services']) {{$service_availed['availed_services']->department_name}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Avail Service Date :</strong>@if($service_availed['availed_services']) {{date_format(date_create($service_availed['availed_services']->date_created),"M d, Y h:i a")}} @endif</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Total Amount:</strong> @if(isset($service_availed['availed_services']->total_price)) {{number_format($service_availed['availed_services']->total_price, 2, '.', ',')}} @endif</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="" class="table ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">Image</th>
                                                <th>Service Name</th>
                                                <th >Service Desc</th>
                                                <th >Quantity</th>
                                                <th >Price / Unit</th>
                                                <th >Partial Price</th>
                                                <th >Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $total = 0;
                                                $valid_cart = true;
                                            ?>
                                            @forelse($service_availed['availed_service_items']  as $key => $value )
                                                <tr>
                                                    <th scope="row" class="align-middle">{{$key +1 }}</th>
                                                    <td class="text-center align-middle">
                                                        <img src="{{asset('storage/content/services/'.$value->service_image)}}" alt="Product Image"  style="object-fit: cover;width:100px; max-height: 100px;">
                                                    </td>
                                                    <td class="align-middle">{{$value->service_name}}</td>
                                                    <td class="align-middle">{{$value->service_description}}</td>
                                                    <td class="align-middle">
                                                        <input type="number"  class="form-control" wire:change="update_total_price()" wire:model="service_availed.availed_service_items.{{$key}}.quantity">
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="number"  class="form-control" wire:change="update_total_price()" step="0.01" wire:model="service_availed.availed_service_items.{{$key}}.price_per_unit">
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="text"  class="form-control bg-white" disabled wire:model="service_availed.availed_service_items.{{$key}}.total_price">
                                                    </td>
                                                    <td class="align-middle" class="form-control" >
                                                        <textarea type="text" value="{{$value->remarks}}" wire:model="service_availed.availed_service_items.{{$key}}.remarks"></textarea>
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