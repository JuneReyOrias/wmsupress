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
                <h4>Year {{$filters['year']}}</h4>
                <h4>Total Revenue {{number_format($total_revenue, 2, '.', ',')}}</h4>
            </div>
            <div class="table-responsive">
                <table id="shoppingCart" class="table-condensed table text-black">
                    <thead>
                        <tr>
                            <th style="width:20%">Track No.</th>
                            <th style="width:12%">Account Name</th>
                            <th style="width:12%" >College</th>
                            <th style="width:12%" >Department</th>
                            <th style="width:12%" class="text-center">Status</th>
                            <th style="width:12%">Price</th>
                            <th style="width:12%">Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer_order as $key =>$value)
                        <tr>
                            <td data-th="Price" class="align-middle">Track No: {{str_pad($value->id, 8, '0', STR_PAD_LEFT)}}</td>
                            <td data-th="Price" class="align-middle">{{$value->first_name.' '.$value->middle_name.' '.$value->last_name}}</td>
                            <td data-th="Price" class="align-middle ">{{$value->college_name}}</td>
                            <td data-th="Price" class="align-middle">{{$value->department_name}}</td>
                            <td data-th="Price" class="align-middle text-center">{{$value->order_status}}</td>
                            <td data-th="Price" class="align-middle ">PHP {{number_format($value->total_price, 2, '.', ',')}}</td>
                            <td data-th="Price" class="align-middle">{{date_format(date_create($value->date_updated),"M d, Y h:i a")}}</td>
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
    </body>
    </html>