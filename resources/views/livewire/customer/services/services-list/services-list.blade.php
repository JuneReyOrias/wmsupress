<div>
    <div class="page-heading products-heading header-text" style="background-image: url('{{url('landingpage')}}/assets/images/products-heading.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>Upress</h4>
                        <h2>Services</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="filters">
                        <ul>
                            <li class="active" data-filter="*">Services</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="filters-content">
                        <div class="row grid">
                            @foreach ($service_data as $key =>$value)
                            <div class="col-lg-4 col-md-4 all " >
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
</div>
