<div>
    <nav class="sidebar">
        
        <div class="sidebar-header" style="background-color: #8d021f;">
            <a href="#" class="sidebar-brand">
                UPRESS
            </a>
            <div class="sidebar-toggler not-active">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="sidebar-body">
            <ul class="nav">
                <li class="nav-item nav-category">
                    Main
                </li>
                <li class="nav-item">
                    <a href="{{route('admin-dashboard')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                    <li class="nav-item nav-category">
                        Components
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#stockin" role="button" aria-expanded="false" aria-controls="uiComponents">
                            <i class="link-icon" data-feather="hard-drive"></i>
                            <span class="link-title">Stock</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div wire:ignore.self class="collapse" id="stockin">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('admin-stocklist') }}" class="nav-link">Stock List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin-stock-in-records') }}" class="nav-link">Stock In Records</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin-stock-out-records') }}" class="nav-link">Stock Out Records</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
                            <i class="link-icon" data-feather="shopping-bag"></i>
                            <span class="link-title">Products</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="uiComponents">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{route('admin-product-list')}}" class="nav-link @if( Route::is('admin-product-list')) active @endif">Product list</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin-product-size')}}" class="nav-link @if( Route::is('admin-product-size')) active @endif">Sizes</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin-product-color')}}" class="nav-link @if( Route::is('admin-product-color')) active @endif">Color</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#services" role="button" aria-expanded="false" aria-controls="advancedUI">
                            <i class="link-icon" data-feather="layers"></i>
                            <span class="link-title">Services</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="services">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{route('admin-servicelist')}}" class="nav-link @if( Route::is('admin-servicelist')) active @endif">Service Lists</a>
                                </li>
                                <li class="nav-item" id="declined-services">
                                    <a href="{{ route('admin-declined-services') }}" class="nav-link @if(Route::is('admin-declined-services')) active @endif">Declined Services</a>
                                </li>
                                <li class="nav-item" id="pending-services">
                                    <a href="{{ route('admin-pending-services') }}" class="nav-link @if(Route::is('admin-pending-services')) active @endif">Pending Services</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route ('admin-approved-services')}}" class="nav-link @if( Route::is('admin-approved-services')) active @endif">Approved Services</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin-rtpi-services')}}" class="nav-link @if( Route::is('admin-rtpi-services')) active @endif">Ready for Pickup</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin-completed-services')}}" class="nav-link @if( Route::is('admin-completed-services')) active @endif">Completed Services</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#orders" role="button" aria-expanded="false" aria-controls="orders">
                            <i class="link-icon" data-feather="shopping-cart"></i>
                            <span class="link-title">Orders</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="orders">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('admin-order-list') }}" class="nav-link @if( Route::is('admin-order-list')) active @endif">All Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin-declined-order') }}" class="nav-link @if( Route::is('admin-declined-order')) active @endif">Declined Orders</a>
                                </li>

                                <li class="nav-item" id="pending-order">
                                    <a href="{{ route('admin-pending-order') }}" class="nav-link @if(Route::is('admin-pending-order')) active @endif">Pending Orders</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="{{ route('admin-confirmed-order') }}" class="nav-link @if( Route::is('admin-confirmed-order')) active @endif">Confirmed Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin-ready-for-pickup-order') }}" class="nav-link @if( Route::is('admin-ready-for-pickup-order')) active @endif">Ready for Pickup Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin-completed-order') }}" class="nav-link @if( Route::is('admin-completed-order')) active @endif">Completed Orders</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#transaction" role="button" aria-expanded="false" aria-controls="transaction">
                            <i class="link-icon" data-feather="credit-card"></i>
                            <span class="link-title">Transactions</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="transaction">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('admin-order-transactionrecords') }}" class="nav-link">Order Transaction Records</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin-service-transactionrecords') }}" class="nav-link">Services Transaction Records</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @if($user_info->role_name == 'admin')
                        <li class="nav-item nav-category">Settings</li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false" aria-controls="general-pages">
                                    <i class="link-icon" data-feather="users"></i>
                                    <span class="link-title">Users</span>
                                    <i class="link-arrow" data-feather="chevron-down"></i>
                                </a>
                                <div class="collapse" id="users">
                                    <ul class="nav sub-menu">
                                        <li class="nav-item" id="adminuseradmin">
                                            <a href="{{route('admin-user-admin')}}" class="nav-link Route::is('admin-user-admin')">Admins</a>
                                        </li>
                                        <li class="nav-item" id="adminuserstaff">
                                            <a href="{{route('admin-user-staff')}}" class="nav-link Route::is('admin-user-admin')">Staffs</a>
                                        </li>
                                        <li class="nav-item" id="adminusercustomer">
                                            <a href="{{route('admin-user-customer')}}" class="nav-link Route::is('admin-user-admin')" >Customers</a>

                                        </li>
                                    </ul>
                                </div>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#colleges" role="button" aria-expanded="false" aria-controls="general-pages">
                                    <i class="link-icon" data-feather="globe"></i>
                                    <span class="link-title">Colleges</span>
                                    <i class="link-arrow" data-feather="chevron-down"></i>
                                </a>
                                <div class="collapse" id="colleges">
                                    <ul class="nav sub-menu">
                                        <li class="nav-item" id="colleges-nav">
                                            <a href="{{route('admin-colleges')}}" class="nav-link Route::is('admin-colleges')">Colleges</a>
                                        </li>
                                        <li class="nav-item" id="departments">
                                            <a href="{{route('admin-colleges').'/departments'}}" class="nav-link Route::is('admin/colleges/*')">Departments</a>
                                        </li>
                                    </ul>
                                </div>
                            </li> 
                        </li> 
                    @endif
                </li>
            </ul>
        </div>
    </nav>
</div>
