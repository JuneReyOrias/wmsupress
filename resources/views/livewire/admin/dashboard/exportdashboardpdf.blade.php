<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src="{{url('/sweetalert2-11.10.1')}}/dist/sweetalert2.all.min.js"></script>
        <link href="{{url('/sweetalert2-11.10.1')}}/dist/sweetalert2.min.css" rel="stylesheet">
     
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <!-- Styles -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
        <meta name="author" content="NobleUI">
        <meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	    <title>UPRESS - Admin</title>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    </head>
    <body>
   
        <div class="row" id="content">
            <div class="row text-center">
                <h4>Year {{$dashboard['current_year']}}</h4>
            </div>
            <div class="col-12 col-xl-12 ">
                <div class="row ">
                    <div class="col-md-4 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">No. of Customers</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5"><br>
                                    <h5 class="mb-2">{{$dashboard['no_of_customer']}}</h5>
                                    <div class="d-flex align-items-baseline">
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="customersChart" class="mt-md-3 mt-xl-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin ">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">No. of Complete Orders</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5"><br>
                                    <h5 class="mb-2">{{$dashboard['no_of_complete_orders']}}</h5>
                                <div class="d-flex align-items-baseline">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="col-md-4 grid-margin ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Product Revenue</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5"><br>
                                <h5 class="mb-2">PHP {{number_format($dashboard['total_product_revenue'],2)}}</h5>
                                <div class="d-flex align-items-baseline">
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="growthChart" class="mt-md-3 mt-xl-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-12 ">
                <div class="row ">
                <div class="col-md-4 grid-margin ">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Services Revenue</h6>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5"><br>
                                        <h5 class="mb-2">PHP {{number_format($dashboard['total_service_revenue'],2)}}</h5>
                                        <div class="d-flex align-items-baseline">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="customersChart" class="mt-md-3 mt-xl-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin ">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Amount Revenue(Php)</h6>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5"><br>
                                        <h5 class="mb-2">PHP {{number_format($dashboard['total_service_revenue'] + $dashboard['total_product_revenue'],2)}}</h5>
                                        <div class="d-flex align-items-baseline">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="ordersChart" class="mt-md-3 mt-xl-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin ">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">No. of Products </h6>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5"><br>
                                        <h5 class="mb-2">{{$dashboard['no_of_products']}}</h5>
                                        <div class="d-flex align-items-baseline">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="ordersChart" class="mt-md-3 mt-xl-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                            <h6 class="card-title mb-0">Product Revenue</h6>
                        </div>
                        <div class="row align-items-start">
                            <div class="col-md-5 d-flex justify-content-md-end mb-10">
                                <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-black">
                                <thead>
                                    <tr>
                                        @foreach($dashboard['product_revenue'] as $key => $value)
                                        <th class="text-center">{{$value->month}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach($dashboard['product_revenue'] as $key => $value)
                                            <th class="text-center">{{$value->total}}</th>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>    
        <div class="col-md-6 grid-margin ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">Order Status</h6>
                    </div>
                    <div class="row align-items-start">
                        <div class="col-md-5 d-flex justify-content-md-end mb-10">
                            <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-black">
                            <thead>
                                <tr>
                                    @foreach($dashboard['order_status'] as $key => $value)
                                        <th class="text-center">{{$value->name}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($dashboard['order_status'] as $key => $value)
                                        <th class="text-center">{{$value->count}}</th>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">Avail Service Status</h6>
                    </div>
                    <div class="row align-items-start">
                        <div class="col-md-5 d-flex justify-content-md-end mb-10">
                            <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-black">
                            <thead>
                                <tr>
                                    @foreach($dashboard['avail_service_status'] as $key => $value)
                                        <th class="text-center">{{$value->name}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($dashboard['avail_service_status'] as $key => $value)
                                        <th class="text-center">{{$value->count}}</th>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>