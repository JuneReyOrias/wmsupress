<div>
    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{route('page-homepage')}}">
                    <h2>WMSU <em>UPRESS</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link @if( Route::is('page-homepage')) active @endif" href="{{route('page-homepage')}}">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if( Route::is('page-products')) active @endif" href="{{route('page-products')}}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if( Route::is('page-services')) active @endif" href="{{route('page-services')}}">Services</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link @if( Route::is('page-about')) active @endif" href="{{route('page-about')}}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if( Route::is('page-contact')) active @endif" href="{{route('page-contact')}}">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if( Route::is('login')) active @endif" href={{route('login')}}>Login</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
</div>
