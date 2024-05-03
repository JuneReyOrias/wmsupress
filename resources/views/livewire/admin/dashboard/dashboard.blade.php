<div>
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <button type="button" class="btn btn-outline-primary me-2 mb-2 mb-md-0" id="printButton">
                    <i data-feather="printer"></i>
                    Print
                </button>
                <button type="button" class="btn btn-primary mb-2 mb-md-0 mx-2" id="printPDF" wire:click="downloadpdf()">
                    <i data-feather="download-cloud"></i>
                    Download Report
                </button>
                <div class="col mx-2">
                    <select name=""  class="form-select" wire:model.live="dashboard.current_year" >
                        @foreach($dashboard['years'] as $key => $value)
                            @if($dashboard['current_year'] ==  $value['year'] )
                                <option selected value="{{ $value['year']}}">Year {{  $value['year']}}</option>
                            @else
                                <option value="{{ $value['year']}}">Year {{  $value['year']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div id="editor"></div>

        <div class="row" id="content">
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
                        <div class="row d-flex justify-content-end ">
                            <div class="col-2">
                                <select name="" class="form-select" id="dashboard_year" onchange="renderRevenueChart()">
                                    @foreach($dashboard['years'] as $key => $value)
                                        <option value="{{ $value['year']}}">Year {{  $value['year']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <select name="" class="form-select" id="revenue_month" onchange="renderRevenueChart()">
                                    <option value="">Select Month</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col-md-5 d-flex justify-content-md-end mb-10">
                                <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                                </div>
                            </div>
                        </div>
                        <canvas id="productRevenueChart" width="100%" height="30"></canvas>

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
                            <div class="orderStatusChart">
                            <canvas id="orderStatusChart"></canvas>
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
                        <div class="availServiceStatusChart">
                        <canvas id="availServiceStatusChart"></canvas>
                        </div>
                    </div>
            </div>
        </div>    

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <script>
        var productRevenueCtx = document.getElementById('productRevenueChart').getContext('2d');
        var productRevenueChartVar;
        window.addEventListener('rerenderChart', function(){
           
        }); 
    
        document.addEventListener('DOMContentLoaded', function() {
            
          
            
            // Service Overview Chart
            var orderStatusDataCtx = document.getElementById('orderStatusChart').getContext('2d');
            var orderStatusDataChart = new Chart(orderStatusDataCtx, {
                type: 'doughnut',
                data: {
                    labels: [
                        
                        <?php 
                        foreach($dashboard['order_status'] as $key =>$value){
                            if ($key === array_key_last($dashboard['order_status'])) {
                            echo "'".$value->name."'";
                            }else{
                                echo "'".$value->name."',";
                            }
                        }
                        ?>
                        
                    ],
                    datasets: [{
                        label: 'Order Status',
                        data: [
                            <?php 
                            foreach($dashboard['order_status'] as $key =>$value){
                                if ($key === array_key_last($dashboard['order_status'])) {
                                echo "".$value->count."";
                                }else{
                                    echo "".$value->count.",";
                                }
                            }
                            ?>
                        ],
                        backgroundColor: [
                            <?php 
                            foreach($dashboard['order_status'] as $key =>$value){
                                if ($key === array_key_last($dashboard['order_status'])) {
                                    echo "'rgba(".rand(100,255).",".rand(100,255).",".rand(100,255).",0.5)'";
                                }else{
                                    echo "'rgba(".rand(100,255).",".rand(100,255).",".rand(100,255).",0.5)',";
                                }
                            }
                            ?>
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            // Service Overview Chart
            var availServiceStatusCtx = document.getElementById('availServiceStatusChart').getContext('2d');
            var availServiceStatusChart = new Chart(availServiceStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Service Status'],
                    datasets: [{
                        label: [
                            'Service Status'
                        ],
                        data: [
                            <?php 
                            foreach($dashboard['avail_service_status'] as $key =>$value){
                                if ($key === array_key_last($dashboard['avail_service_status'])) {
                                    echo "".$value->count."";
                                }else{
                                    echo "".$value->count.",";
                                }
                            }
                            ?>
                        ],
                        backgroundColor: [
                            <?php 
                            foreach($dashboard['avail_service_status'] as $key =>$value){
                                if ($key === array_key_last($dashboard['avail_service_status'])) {
                                    echo "'rgba(".rand(100,255).",".rand(100,255).",".rand(100,255).",0.5)'";
                                }else{
                                    echo "'rgba(".rand(100,255).",".rand(100,255).",".rand(100,255).",0.5)',";
                                }
                            }
                            ?>
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });

        flatpickr("#dashboardDate", {
        });


        var printButton = document.getElementById('printButton');

        printButton.addEventListener('click', function() {
            window.print();
        });
        function downloadPdf(){
            var doc = new jsPDF({
            orientation: 'landscape',
            unit: 'in',
            format: [8, 11]
            })

            doc.text('Hello world!', 0, 10)
            doc.save('two-by-four.pdf')

        }
        
       
        

    </script>
    <script>
    function renderRevenueChart(){
        var month = $('#revenue_month').val()
        var year = $('#dashboard_year').val()
        var monthdata;
        var monthlabel;
        var bgcolor = []
        const randomBetween = (min, max) => min + Math.floor(Math.random() * (max - min + 1));
        if(!month){
            month = -1
        }
        $.ajax({url: '/admin/dashboard/product-revenue/'+year+'/'+month, 
        success: function(result){
            var set = true;
            var revenue_month = '<option value="">Select Month</option>' ;
            result.total_product_revenue_months.forEach(element  => {
                if(month == element.month){
                    revenue_month+= '<option selected value="'+element.month+'">'+element.month_label+'</option>';
                }else{
                    revenue_month+= '<option value="'+element.month+'">'+element.month_label+'</option>';
                }
            });
            $('#revenue_month').html(revenue_month);
            result.product_revenue.forEach(element  => {
                if(element.day){
                    if(set){
                        monthdata = []
                        monthlabel = []
                        monthlabel_x = ['January','February','March','April','May','June','July','August','September','October','November','December']
                        set = false;
                    }
                
                    monthdata.push(element.total)
                    monthlabel.push(monthlabel_x[month-1]+' '+element.day)
                }else{
                    if(set){
                        monthdata = [0,0,0,0,0,0,0,0,0,0,0,0]
                        monthlabel = ['January','February','March','April','May','June','July','August','September','October','November','December']
                        set = false;
                    }
                    monthdata[element.month-1] = element.total
                    monthlabel[element.month-1] = monthlabel[element.month-1]+' ('+element.total+')'
                }
            
                bgcolor.push('rgb('+(randomBetween(0, 255))+','+(randomBetween(0, 255))+','+(randomBetween(0, 255))+')')
                });
                if(productRevenueChartVar){
                    productRevenueChartVar.destroy();
                }
                productRevenueChartVar = new Chart(productRevenueCtx, {
                type: 'bar',
                data: {
                    labels: monthlabel,
                    datasets: [{
                        label: 'Product Revenue',
                        data: monthdata,
                        backgroundColor: bgcolor,
                        borderWidth: 1,
                    }]
                    },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            }
        });
    }

    renderRevenueChart()
    </script>

    <style>
        .availServiceStatusChart, .orderStatusChart {
        max-height: 90%;
        width: auto;

    }
    @media print {
        #printButton,
        #printPDF {
            display: none;
        }
    }

    .navbar-container {
        display: block;
    }

    @media print {
        .navbar-container {
            display: none;
        }
    }
 </style>
  
</div>



