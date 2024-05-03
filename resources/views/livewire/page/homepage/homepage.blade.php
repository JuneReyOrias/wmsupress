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
            <h2>SERVICES</h2>
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
                                        <a href="#">
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
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="pagination-container mt-3">
                        <ul class="pagination">
                            <li><a href="{{ $stocks_data->previousPageUrl() }}">Previous</a></li>
                            @foreach ($stocks_data->getUrlRange(1, $stocks_data->lastPage()) as $page => $url)
                                <li class="{{ $page == $stocks_data->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            <li><a href="{{ $stocks_data->nextPageUrl() }}">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add to Cart</h2>
            <p id="productName"></p>
            
            <!-- Form for color select, quantity input, and other color input -->
            <form action="{{ url('CartNew') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="col-md-4 form-group">
                        <label for="typeSelect">Type:</label>
                        <select id="typeSelect" name="type" class="form-control">
                            <option value="product">Product</option>
                            <option value="services">Services</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="colorSelect">Select Color:</label>
                        <select id="colorSelect" name="color" onchange="checkColor()" class="form-control">
                            <option value="red">Red</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="quantityInput">Quantity:</label>
                        <input type="number" id="quantityInput" name="quantity" value="1" min="1" class="form-control" onchange="calculateTotal()">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="totalPrice">Total Price:</label>
                        <input type="text" id="totalPrice" name="total_amount" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group" id="otherColorInputContainer" style="display: none;">
                    <label for="otherColorInput">Enter Color:</label>
                    <input type="text" id="otherColorInput" name="othercolor" class="form-control" placeholder="Enter Color">
                </div>
                <input type="hidden" id="productNameInput" name="item_name">
                <input type="hidden" id="productPriceInput" name="unit_price">
                <input type="hidden" id="unitPriceInput" name="unit_price">
                <input type="hidden" name="product_id">
                <input type="hidden" name="users_id">
                <input type="hidden" id="userIdInput" name="image">
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>

    <script>
      function openModal(productName, productPrice, userId) {
          document.getElementById("productName").textContent = productName;
          document.getElementById("productNameInput").value = productName;
          document.getElementById("productPriceInput").value = productPrice;
          document.getElementById("unitPriceInput").value = productPrice;
          document.getElementById("userIdInput").value = userId;
          document.getElementById("cartModal").style.display = "block";
          calculateTotal(); // Calculate total price initially
      }

      function closeModal() {
          document.getElementById("cartModal").style.display = "none";
      }

      function checkColor() {
          var colorSelect = document.getElementById("colorSelect");
          var otherColorInputContainer = document.getElementById("otherColorInputContainer");
          if (colorSelect.value === "other") {
              otherColorInputContainer.style.display = "block";
          } else {
              otherColorInputContainer.style.display = "none";
          }
      }
    </script>

    <script>
      function calculateTotal() {
      // Get the quantity input value
      var quantity = parseInt(document.getElementById("quantityInput").value);

      // Get the unit price from the hidden input field or any other source
      var unitPrice = parseFloat(document.getElementById("unitPriceInput").value);

      // Calculate the total price by multiplying quantity and unit price
      var totalPrice = quantity * unitPrice;

      // Display the total price in the "Total Price" input field
      document.getElementById("totalPrice").value = totalPrice.toFixed(2); // Ensure to format the total price as needed
      }
    </script>
    <div class="latest-products">
      <div class="container">
        <div class="row">

          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Servicess</h2>
              <a href="{{route('page-services')}}">view all services <i class="fa fa-angle-right"></i></a>
            </div>
          </div>

          <div class="col-md-12">
            <div class="filters-content">
              <div class="row grid">
                  @foreach ([] as $service)
                  <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                          <a href="#"><img src="/servicesimages/{{$service->image}}" alt="" style="width: 100%; height: 200px;bservice-radius: 10px;"></a>
                          <div class="down-content">
                              <a href="#">
                                  <h4 class="">{{$service->category}}</h4>
                              </a>
                              <div class="" style="gap:5px;"><h6>Php {{$service->unit_price}}</h6></div>
                              
                              <h4>Description:<p>{{$service->descritpion}}</p></h4>
                              <p>Stocks: {{$service->stocks}}</p>
                              <p>Status: {{$service->status}}</p>
                              
                              {{-- <!-- Add Cart button with onclick event -->
                              <button class="btn btn-primary" onclick="openModal('{{$service->product_name}}', '{{$service->unit_price}}', '{{$service->image}}')">Add Cart</button> --}}
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


  
    <script>
      function openModal(productName, productPrice, userId) {
          document.getElementById("productName").textContent = productName;
          document.getElementById("productNameInput").value = productName;
          document.getElementById("productPriceInput").value = productPrice;
          document.getElementById("unitPriceInput").value = productPrice;
          document.getElementById("userIdInput").value = userId;
          document.getElementById("cartModal").style.display = "block";
          calculateTotal(); // Calculate total price initially
      }

      function closeModal() {
          document.getElementById("cartModal").style.display = "none";
      }

      function checkColor() {
          var colorSelect = document.getElementById("colorSelect");
          var otherColorInputContainer = document.getElementById("otherColorInputContainer");
          if (colorSelect.value === "other") {
              otherColorInputContainer.style.display = "block";
          } else {
              otherColorInputContainer.style.display = "none";
          }
      }
    </script>

    <script>
      function calculateTotal() {
      // Get the quantity input value
      var quantity = parseInt(document.getElementById("quantityInput").value);

      // Get the unit price from the hidden input field or any other source
      var unitPrice = parseFloat(document.getElementById("unitPriceInput").value);

      // Calculate the total price by multiplying quantity and unit price
      var totalPrice = quantity * unitPrice;

      // Display the total price in the "Total Price" input field
      document.getElementById("totalPrice").value = totalPrice.toFixed(2); // Ensure to format the total price as needed
      }
    </script>

    <script>
      // Add event listeners to filter buttons
      document.addEventListener('DOMContentLoaded', function () {
          var filterButtons = document.querySelectorAll('.filters ul li');
          filterButtons.forEach(function (button) {
              button.addEventListener('click', function () {
                  var filterValue = button.getAttribute('data-filter');
                  filterServices(filterValue);
              });
          });
      });

      // Function to filter services based on category
      function filterServices(filterValue) {
          var serviceItems = document.querySelectorAll('.filters-content .product-item');
          serviceItems.forEach(function (item) {
              if (filterValue === '*' || item.classList.contains(filterValue)) {
                  item.style.display = 'block'; // Show item if it matches the filter or filter is '*'
              } else {
                  item.style.display = 'none'; // Hide item if it doesn't match the filter
              }
          });
      }

      // Initially show all services
      filterServices('*');
    </script>

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
                <li><a href="#">Professional printing services for academic journals</a></li>
                <li><a href="#">High-quality printing of textbooks and educational materials</a></li>
                <li><a href="#">Printing of research papers and conference proceedings</a></li>
                <li><a href="#">Publication of literary works and creative endeavors</a></li>
               
              </ul>
              <a href="" class="filled-button">Read More</a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="right-image">
              <img src="landingpage/assets/images/feature-image.jpg" alt="">
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
                  <p>Discover UPRESS's captivating array of creative and unique products,</p>
                  <p> ranging from custom scholarly anthologies and augmented reality </p>
                  <p>textbooks to limited edition art books and eco-friendly paper products.</p>
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