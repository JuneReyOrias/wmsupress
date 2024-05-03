<div>
    <div class="banner header-text">
        <div class="owl-banner owl-carousel">
            <div class="banner-item-01" style="background-image: url('../landingpage/assets/images/wmsu.jpg');" >
                <div class="text-content">
                    <h4>WMSU</h4>
                    <h2>UPRESS</h2>
                </div>
            </div>
            <div class="banner-item-02" style="background-image: url('../landingpage/assets/images/slide_02.jpg');">
                <div class="text-content">
                    <h4>UPRESS</h4>
                    <h2>Products</h2>
                </div>
            </div>
            <div class="banner-item-03" style="background-image: url('../landingpage/assets/images/slide_03.jpg');">
                <div class="text-content">
                    <h4>UPRESS</h4>
                    <h2  >SERVICES</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="latest-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Latest Products</h2>
                        <a href="{{ route('page-products') }}">View all products <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="filters-content">
                        <div class="row grid">
                            @foreach ($stocks_data as $key => $value)
                                <div class="col-lg-4 col-md-4 all " >
                                    <div class="product-item">
                                        <a href="{{asset('storage/content/products/'.$value->product_image)}}" target="_blank">
                                            <img src="{{asset('storage/content/products/'.$value->product_image)}}" alt="" style="object-fit:contain; height: 200px; border-radius: 10px;">
                                        </a>
                                        <div class="down-content">
                                            <div class="row mx-2">
                                                <a href="#">
                                                    <h4>{{ $value->product_name }}</h4>
                                                </a>
                                                <div style="gap: 5px;">
                                                    <h6>
                                                        Php {{ $value->product_price }}
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="row mx-2">
                                                <p>Status: @if($value->is_active ) Available @else Unavailable @endif</p>
                                            </div>
                                            <div class="row mx-2" style="height:50px">
                                                @if($value->product_description)
                                                <h4>
                                                    Description:<p class="my-2">{{ $value->product_description }}</p>
                                                </h4>
                                                @endif
                                            </div>
                                            <div class="row mx-2 mt-4 ">
                                                <button class="btn btn-success" type="button" wire:click="add_to_cart({{$value->id}},'cartModalToggler')" >Add Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#cartModal" id="cartModalToggler" style="display:none">Add</button>
                    
                    <div wire:ignore.self class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="col-md-12 ">
                                    <span class="btn btn" data-bs-toggle="modal" style="display: flex; justify-content:end; font-size:32px">
                                        &times;
                                    </span> 
                                    <form wire:submit.prevent="save_add_to_cart('cartModalToggler')">
                                        <div class="modal-body bg-white">
                                            <div class="mb-3">
                                                <h4>
                                                    @if($current_cart['product'])
                                                        {{$current_cart['product']->name}}
                                                    @endif
                                                </h4>
                                            </div>
                                            <div class="mb-3">
                                                <label for="productCode" class="form-label text-black">Size:</label>
                                                <select class="form-select"  wire:model="current_cart.product_size_id" wire:change="update_product_color_details()" name="role" required id="role" aria-label="Select Role">
                                                    <option selected value="">Select Size</option>    
                                                    @foreach($current_cart['product_sizes'] as $key =>$value)
                                                    <option value="{{$value->product_size_id}}">{{$value->product_size_description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="productCode" class="form-label text-black text-start">Color:</label>
                                                <select class="form-select"  wire:model="current_cart.product_color_id" wire:change="update_product_size_details()" name="role" required id="role" aria-label="Select Role">
                                                    <option selected value="">Select Color</option>    
                                                    @foreach($current_cart['product_colors'] as $key =>$value)
                                                    <option value="{{$value->product_color_id}}">{{$value->product_color_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label text-black">Quantity:</label>
                                                <input type="number" wire:change="update_max_stock()" min="1" max="1000" step="1" wire:model="current_cart.quantity" class="form-control bg-white" id="quantity" name="quantity" required>
                                            </div>
                                            @if($current_cart['error'])
                                                <div class="col-md-12 mx-3">
                                                    <p style ="color:red">Error: {{$current_cart['error']}}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer bg-white">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px">Cancel</button>
                                            <button  class="btn btn-success" type="submit" style="border-radius: 8px">Add to cart</button>
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

 
    <div class="latest-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                    <h2>Latest Servicess</h2>
                    <a href="{{route('customer-service-list')}}">View All Services <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="filters-content">
                        <div class="row grid">
                            @foreach ($service_data as $key =>$value)
                                <div class="col-lg-4 col-md-4 " >
                                    <div class="product-item">
                                        <a href="#">
                                            <img src="{{asset('storage/content/services/'.$value->image)}}" alt="" style="object-fit:contain; height: 200px; border-radius: 10px;">
                                        </a>
                                        <div class="down-content">
                                            <div class="row mx-2">
                                                <a href="#">
                                                    <h4>{{ $value->name }}</h4>
                                                </a>
                                            </div>
                                            <div class="row mx-2">
                                                <p>Status: @if($value->is_active ) Available @else Unavailable @endif</p>
                                            </div>
                                            <div class="row mx-2 my-2" style="height:80px">
                                                @if($value->description)
                                                <h4 >
                                                    Description:<p>{{ $value->description }}</p>
                                                </h4>
                                                @endif
                                            </div>
                                            <div class="row mx-2 mt-4 ">
                                                <button class="btn btn-success" wire:click="add_to_service_cart({{$value->id}})" >Avail Service</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="best-features">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                    <h2>About WMSU UPRESS</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left-content">
                    <h4>Looking for the best products?</h4>
                    <p><a rel="nofollow" href="https://templatemo.com/tm-546-sixteen-clothing" target="_parent">This template</a> is free to use for your business websites. However, you have no permission to redistribute the downloadable ZIP file on any template collection website. <a rel="nofollow" href="https://templatemo.com/contact">Contact us</a> for more info.</p>
                    <ul class="featured-list">
                        <li><a href="#">Lorem ipsum dolor sit amet</a></li>
                        <li><a href="#">Consectetur an adipisicing elit</a></li>
                        <li><a href="#">It aquecorporis nulla aspernatur</a></li>
                        <li><a href="#">Corporis, omnis doloremque</a></li>
                        <li><a href="#">Non cum id reprehenderit</a></li>
                    </ul>
                    <a href="about.html" class="filled-button">Read More</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-image">
                    <img src="/landingpage/assets/images/feature-image.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Creative &amp; Unique <em>UPRESS</em> Products</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque corporis amet elite author nulla.</p>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="filled-button">Purchase Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>