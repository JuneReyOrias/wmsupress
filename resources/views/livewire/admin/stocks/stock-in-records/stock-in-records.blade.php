<div>
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card border rounded">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Product Stock In Records</h3>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-4">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered text-black">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Image</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Product Size</th>
                                        <th>Product Color</th>
                                        <th>Stock In Qty</th>
                                        <th>Stocked In By</th>
                                        <th>Stocked In Date</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @forelse ($stock_in_out_records  as $key => $value )
                                        <tr>
                                            <th scope="row" class="align-middle">{{(intval($stock_in_out_records->currentPage()-1)*$stock_in_out_records->perPage())+$key+1 }}</th>
                                            <td class="text-center align-middle">
                                                <img src="{{asset('storage/content/products/'.$value->product_image)}}" alt="Product Image"  style="object-fit: cover;width:150px height: 150px;">
                                            </td>
                                            <td class="align-middle">{{$value->product_code}}</td>
                                            <td class="align-middle">{{$value->product_name}}</td>
                                            <td class="align-middle">{{$value->product_size}}</td>
                                            <td class="align-middle">{{$value->product_color}}</td>
                                            <td class="align-middle">{{$value->stock_quantity}}</td>
                                            <td class="align-middle">{{$value->first_name.' '.$value->middle_name.' '.$value->last_name }}</td>
                                            <td class="align-middle">{{date_format(date_create($value->date_created),"M d, Y h:i a")}}</td>
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
                                <li><a href="{{ $stock_in_out_records->previousPageUrl() }}">Previous</a></li>
                                @foreach ($stock_in_out_records->getUrlRange(1, $stock_in_out_records->lastPage()) as $page => $url)
                                    <li class="{{ $page == $stock_in_out_records->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $stock_in_out_records->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
