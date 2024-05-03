
<div>

    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-dark">
                            <h3 class="text-center text-white">Review Order</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-black">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Lanyard, Red</td>
                                            <td>$300</td>
                                            <td>3</td>
                                            <td>$900</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td>$900</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-muted text-center bg-transparent">
                            <!-- Button to trigger payment modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                Proceed to Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-light">
                    <h5 class="modal-title" id="paymentModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <div class="list-group">
                        <div class="list-group-item bg-white">
                            <div class="d-flex w-100 justify-content-between text-black">
                                <h5 class="mb-1">Order ID:</h5>
                                <span class="text">1</span>
                            </div>
                        </div>
                        <div class="list-group-item bg-white">
                            <div class="d-flex w-100 justify-content-between text-black">
                                <h5 class="mb-1">Customer Name:</h5>
                                <span class="text">John Doe</span>
                            </div>
                        </div>
                        <div class="list-group-item bg-white">
                            <div class="d-flex w-100 justify-content-between text-black">
                                <h5 class="mb-1">Product:</h5>
                                <span class="text">Lanyard (Red, Large)</span>
                            </div>
                        </div>
                        <div class="list-group-item bg-white">
                            <div class="d-flex w-100 justify-content-between text-black">
                                <h5 class="mb-1">Unit Price:</h5>
                                <span class="text">$300</span>
                            </div>
                        </div>
                        <div class="list-group-item bg-white">
                            <div class="d-flex w-100 justify-content-between text-black">
                                <h5 class="mb-1">Quantity:</h5>
                                <span class="text">3</span>
                            </div>
                        </div>
                        <div class="list-group-item bg-white">
                            <div class="d-flex w-100 justify-content-between text-black">
                                <h5 class="mb-1">Total Amount:</h5>
                                <span class="text">$900</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    
                    <form id="paymentForm">
                        <div class="form-group">
                            <label for="imageUpload">Upload OR</label>
                            <input type="file" class="form-control-file border" id="imageUpload" accept="image/*" required>
                            <!-- 'accept="image/*"' ensures only image files can be selected -->
                        </div>
                        <div id="outOfStockMessage" class="alert alert-danger" style="display: none;">
                            The product is currently out of stock.
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal">Pay</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal (Displayed after successful payment) -->
    <div class="modal fade modal-lg" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-light text-center">
                    <h5 class="modal-title" id="successModalLabel">Order Successful!</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body bg-white text-black">
                    <div class="container-fluid">
                        <!-- Header Section -->
                        <div class="row justify-content-center align-items-center mb-4 border-bottom">
                            <!-- University Logo 1 -->
                            <div class="col-6 col-md-3 text-center">
                                <img class="img-fluid rounded-circle mb-2" src="{{url('assets')}}/logo/wmsu-logo.png" alt="University Logo" style="max-width: 100px;">
                            </div>

                            <!-- University Details -->
                            <div class="col-6 col-md-3 text-center ">
                                <span>Western Mindanao State University</span><br>
                                <h5>UNIVERSITY PRESS</h5>
                                <span>Zamboanga City</span>
                            </div>

                            <!-- University Logo 2 -->
                            <div class="col-6 col-md-3 text-center">
                                <img class="img-fluid rounded-circle mb-2" src="{{url('assets')}}/logo/upress-logo.png" alt="University Logo" style="max-width: 100px;">
                            </div>
                        </div>

                        <!-- Transaction Details and Payment Proof -->
                        <div class="row">
                            <!-- Left Column (Transaction Information) -->
                            <div class="col-md-6 mt-3 ">
                                <div class="mb-2 ">
                                    <p><strong>Order ID:</strong> 1</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Customer Name:</strong> John Doe</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>College:</strong> College of Computing Studies</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Department:</strong> Computer Science</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Product:</strong> Lanyard (Red, Large)</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Unit Price:</strong> $300</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Quantity:</strong> 3</p>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Total Amount:</strong> $900</p>
                                </div>
                            </div>

                            <!-- Right Column (Payment Proof Image) -->
                            <div class="col-md-6 text-center">
                                <div class="mb-0">
                                    <p><strong>Payment Proof:</strong></p>
                                    <img src="https://via.placeholder.com/300" class="img-fluid" alt="Payment Proof">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer bg-white text-black">
                      <a href="#"  onclick="print_this('to_print')" class="btn btn-secondary">Print</a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>
        function processPayment() {
          
            const paymentAmount = document.getElementById('paymentAmount').value;
        
            setTimeout(function() {
                $('#paymentModal').modal('hide'); // Hide payment modal
                $('#successModal').modal('show'); // Show success modal
            }, 1000); 
        }
    </script> -->

</div>



