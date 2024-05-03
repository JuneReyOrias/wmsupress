<div>
    <div class="container " style="">
        <div class="row" style="height:150px"></div>
            <div class="row">
                <div class="card card-body border rounded">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="col-lg-12 col-md-12 col-12">
                                <h3 class="display-5 mb-2 text-center"> Avail Service</h3>
                                <p class="mb-5 text-center">
                                <div class="table-responsive">
                                    <table id="" class="table ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">Image</th>
                                                <th>Service Name</th>
                                                <th >Service Desc</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $total = 0;
                                                $valid_cart = true;
                                            ?>
                                            @forelse($service_cart  as $key => $value )
                                                <?php if(!$value->is_active) {$valid_cart = false;}?>
                                                <tr @if(!$value->is_active) class="bg-danger" @endif>
                                                    <th scope="row" class="align-middle">{{$key +1 }}</th>
                                                    <td class="text-center align-middle">
                                                        <img src="{{asset('storage/content/services/'.$value->service_image)}}" alt="Product Image"  style="object-fit: cover;width:100px; max-height: 100px;">
                                                    </td>
                                                    <td class="align-middle">{{$value->service_name}}</td>
                                                    <td class="align-middle">{{$value->service_description}}</td>
                                                    <td class="text-center align-middle">
                                                        <button class="btn-danger btn" wire:click="remove_item_default({{$value->id}},'removeModalToggler')">
                                                            Remove
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
                                <br>
                                @if(!$valid_cart)
                                <div class="row ">
                                    <p class="text-danger"> Some items are not available anymore, please remove the item!</p>
                                </div>
                                @endif
                                @if($error)
                                <div class="row ">
                                    <p class="text-danger"> {{$error}}</p>
                                </div>
                                @endif
                                <div class="row mt-4 d-flex align-items-center justify-content-end">
                                    <div class="col-sm-6 order-md-1 text-right">
                                        <button  @if($valid_cart) class="btn btn-success" @else class="btn btn-danger" disabled @endif 
                                        data-bs-toggle="modal" data-bs-target="#confirmModal">Avail Service</button>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#removeModal" id="removeModalToggler" style="display:none">Add</button>
                            <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#confirmModal" id="confirmModalToggler" style="display:none">Add</button>
                        
                            <div wire:ignore.self class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="removeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="col-md-12 ">
                                            <span class="btn btn" data-bs-toggle="modal" style="display: flex; justify-content:end; font-size:32px">
                                                &times;
                                            </span> 
                                            <form wire:submit.prevent="remove_item({{$service_cart_id}},'removeModalToggler')">
                                                <div>
                                                    <p> Are you sure you want to remove item?</p>
                                                </div>
                                                <div class="modal-footer bg-white">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px">Cancel</button>
                                                    <button  class="btn btn-success" type="submit" style="border-radius: 8px">Confirm</button>
                                                </div>
                                            </form>
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div wire:ignore.self class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true" style="margin-top:60px;">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <form wire:submit.prevent="avail_service('confirmModalToggler')">
                                            <div class="modal-header bg-dark">
                                                <h5 class="modal-title text-white" id="confirmModalLabel">Confirmation</h5>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-bold"> Are you sure you want to order?</p>
                                            </div>
                                            @if($error)
                                            <div class="row ">
                                                <p class="text-danger"> {{$error}}</p>
                                            </div>
                                            @endif
                                            <div class="modal-footer bg-white">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px">Cancel</button>
                                                <button  class="btn btn-success" type="submit" style="border-radius: 8px">Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
