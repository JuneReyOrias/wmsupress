<?php

use Illuminate\Support\Facades\Route;


//middlewares
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsValid;
use App\Http\Middleware\Logout;
use App\Http\Middleware\Unauthenticated;
use App\Http\Middleware\CheckRoles;
use App\Http\Middleware\isStaff;
use App\Http\Middleware\isCustomer;

// authentications
use App\Livewire\Authentication\Login;
use App\Livewire\Authentication\Logout as AuthenticationLogout;

use App\Http\Controllers\admindashboard as Conadmindashboard;
// admin
use App\Livewire\Admin\Dashboard\Dashboard as AdminDashboard;
use App\Livewire\Admin\Orders\ProductOrders\ProductOrders  as AdminProductOrders; 
use App\Livewire\Admin\Products\Color\Color as AdminProductColor;
use App\Livewire\Admin\Products\Productlist\Productlist  as AdminProductlist;
use App\Livewire\Admin\Products\Sizes\Sizes as AdminProductSizes;
use App\Livewire\Admin\Profile\Profile\Profile as AdminProfile;
use App\Livewire\Admin\Services\Approvedservices\Approvedservices as AdminApprovedservices;
use App\Livewire\Admin\Services\Completedservices\Completedservices as AdminCompletedservices;
use App\Livewire\Admin\Services\Declinedservices\Declinedservices as AdminDeclinedservices;
use App\Livewire\Admin\Services\Pendingservices\Pendingservices as AdminPendingservices;
use App\Livewire\Admin\Services\Servicelist\Servicelist as AdminServicelist;
use App\Livewire\Admin\Services\ServicesReadyToPickUp\ServicesReadyToPickUp as AdminServicesReadyToPickUp;
use App\Livewire\Admin\Stocks\Stocklist\Stocklist as AdminStocklist;
use App\Livewire\Admin\Stocks\StockInRecords\StockInRecords as AdminStockInRecords;
use App\Livewire\Admin\Stocks\StockOutRecords\StockOutRecords as AdminStockOutRecords;
use App\Livewire\Admin\Transactions\Transactionrecords\Transactionrecords as AdminTransactionrecords;
use App\Livewire\Admin\Transactions\ServiceTransactionRecords\ServiceTransactionRecords as AdminServiceTransactionRecords;
use App\Livewire\Admin\Users\Admin\Admin as AdminUsers;
use App\Livewire\Admin\Users\Customers\Customers as AdminCustomers;
use App\Livewire\Admin\Users\Staff\Staff as AdminStaff;
use App\Livewire\Admin\Orders\Revieworders\Revieworders as AdminRevieworders;

use App\Livewire\Admin\Orders\CompletedOrder\CompletedOrder as AdminCompletedOrder;
use App\Livewire\Admin\Orders\ConfirmedOrder\ConfirmedOrder as AdminConfirmedOrder;
use App\Livewire\Admin\Orders\DeclinedOrder\DeclinedOrder as AdminDeclinedOrder;
use App\Livewire\Admin\Orders\OrderList\OrderList as AdminOrderList;
use App\Livewire\Admin\Orders\PendingOrder\PendingOrder as AdminPendingOrder;
use App\Livewire\Admin\Orders\ReadyForPickup\ReadyForPickup as AdminReadyForPickup;
use App\Livewire\Admin\Colleges\Colleges\Colleges as AdminColleges;
use App\Livewire\Admin\Colleges\Departments\Departments as AdminDepartments;

// customer
use App\Livewire\Customer\Cart\Cart as CustomerCart;
use App\Livewire\Customer\Contact\Contact as CustomerContact;
use App\Livewire\Customer\Dashboard\Dashboard as CustomerDashboard;
use App\Livewire\Customer\Order\CancelledOrder\CancelledOrder as CustomerCancelledOrder;
use App\Livewire\Customer\Order\CompleteOrder\CompleteOrder as CustomerCompleteOrder;
use App\Livewire\Customer\Order\ConfirmedOrder\ConfirmedOrder as CustomerConfirmedOrder;
use App\Livewire\Customer\Order\DeclinedOrder\DeclinedOrder as CustomerDeclinedOrder;
use App\Livewire\Customer\Order\Orderlist\Orderlist as CustomerOrderList;
use App\Livewire\Customer\Order\PendingOrder\PendingOrder as CustomerPendingOrder;
use App\Livewire\Customer\Order\ReadyForPickup\ReadyForPickup as CustomerReadyForPickup;

use App\Livewire\Customer\Products\Products as CustomerProducts;
use App\Livewire\Customer\Profile\Profile as CustomerProfile;
use App\Livewire\Customer\TrackOrder\TrackOrder as CustomerTrackOrder;
use App\Livewire\Customer\Services\ServicesCart\ServicesCart as CustomerServicesCart; 
use App\Livewire\Customer\Services\ServicesList\ServicesList as CustomerServicesList;

use App\Livewire\Customer\Services\ServicesAll\ServicesAll as CustomerServicesAll;
use App\Livewire\Customer\Services\ServicesReadyToPickUp\ServicesReadyToPickUp as CustomerServicesReadyToPickUp;
use App\Livewire\Customer\Services\ServicesApproved\ServicesApproved as CustomerServicesApproved;
use App\Livewire\Customer\Services\ServicesCancelled\ServicesCancelled as CustomerServicesCancelled;
use App\Livewire\Customer\Services\ServicesCompleted\ServicesCompleted as CustomerServicesCompleted;
use App\Livewire\Customer\Services\ServicesDeclined\ServicesDeclined as CustomerServicesDeclined;
use App\Livewire\Customer\Services\ServicesPending\ServicesPending as CustomerServicesPending;

// pages
use App\Livewire\Page\About\About;
use App\Livewire\Page\Contact\Contact;
use App\Livewire\Page\Homepage\Homepage; 
use App\Livewire\Page\Products\Products;
use App\Livewire\Page\Services\Services;
use App\Livewire\Page\LatestProduct\LatestProduct;

Route::middleware([CheckRoles::class])->group(function () {
    Route::get('/about',About::class)->name('page-about');
    Route::get('/contact',Contact::class)->name('page-contact');
    Route::get('/',Homepage::class)->name('page-homepage');
    Route::get('/products',Products::class)->name('page-products');
    Route::get('/services',Services::class)->name('page-services');
    Route::get('/product/latest',LatestProduct::class)->name('page-latest-product');
    
});

Route::get('/logout', AuthenticationLogout::class)->middleware(Logout::class)->name('logout');

Route::middleware([Authenticated::class])->group(function () {
    Route::get('/login', Login::class)->name('login');
});


Route::middleware([Unauthenticated::class,IsAdmin::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', AdminDashboard::class)->name('admin-dashboard');
        Route::get('dashboard/product-revenue/{year}/{month}', [Conadmindashboard::class,'product_revenue'])->name('admin-dashboard-product-revenue');
       
        Route::get('profile', AdminProfile::class)->name('admin-profile');

        Route::prefix('stock')->group(function () {
            Route::get('stocklist', AdminStocklist::class)->name('admin-stocklist'); 
            Route::get('stockinrecords', AdminStockInRecords::class)->name('admin-stock-in-records'); 
            Route::get('stockoutrecords', AdminStockOutRecords::class)->name('admin-stock-out-records'); 
        });
        Route::prefix('products')->group(function () {
            Route::get('product-list', AdminProductlist::class)->name('admin-product-list'); 
            Route::get('product-size', AdminProductSizes::class)->name('admin-product-size'); 
            Route::get('product-color', AdminProductColor::class)->name('admin-product-color'); 
        });
        Route::prefix('user')->group(function () {
            Route::get('adminusers', AdminUsers::class)->name('admin-user-admin');
            Route::get('staffusers', AdminStaff::class)->name('admin-user-staff');
            Route::get('customerusers', AdminCustomers::class)->name('admin-user-customer');
        });

        Route::prefix('transactions')->group(function () {
            Route::get('ordertransactionrecord',AdminTransactionrecords::class)->name('admin-order-transactionrecords');
            Route::get('servicetransactionrecord',AdminServiceTransactionRecords::class)->name('admin-service-transactionrecords');
        });
        Route::prefix('colleges')->group(function () {
            Route::get('/',AdminColleges::class)->name('admin-colleges');
            Route::get('{id}',AdminDepartments::class)->name('admin-departments');
            Route::get('{id}',AdminDepartments::class)->name('admin-colleges-departments');
        });

        Route::prefix('orders')->group(function () {
            Route::get('product-orders',AdminProductOrders::class)->name('admin-product-orders');
            Route::get('revieworders',AdminRevieworders::class)->name('admin-revieworders');

            Route::get('completed',AdminCompletedOrder::class)->name('admin-completed-order');
            Route::get('confirmed',AdminConfirmedOrder::class)->name('admin-confirmed-order');
            Route::get('declined',AdminDeclinedOrder::class)->name('admin-declined-order');
            Route::get('order-list',AdminOrderList::class)->name('admin-order-list');
            Route::get('pending',AdminPendingOrder::class)->name('admin-pending-order');
            Route::get('ready-for-pickup',AdminReadyForPickup::class)->name('admin-ready-for-pickup-order');
            

        });

        Route::prefix('services')->group(function () {
            Route::get('servicelist',AdminServicelist::class)->name('admin-servicelist');
            Route::get('pendingservices',AdminPendingservices::class)->name('admin-pending-services');
            Route::get('declinedservices',AdminDeclinedservices::class)->name('admin-declined-services');
            Route::get('approvedservices',AdminApprovedservices::class)->name('admin-approved-services');
            Route::get('ready-to-pick-up',AdminServicesReadyToPickUp::class)->name('admin-rtpi-services');
            Route::get('completedservices',AdminCompletedservices::class)->name('admin-completed-services');
        });

    });
});



Route::middleware([Unauthenticated::class,isStaff::class])->group(function () {
    Route::prefix('staff')->group(function () {
        Route::get('dashboard', AdminDashboard::class)->name('staff-dashboard');
        Route::get('profile', AdminProfile::class)->name('staff-profile');

    });
});

Route::middleware([Unauthenticated::class,isCustomer::class])->group(function () {
    Route::prefix('customer')->group(function () {
        Route::get('cart', CustomerCart::class)->name('customer-cart');
        Route::get('dashboard', CustomerDashboard::class)->name('customer-dashboard');
        Route::get('service-cart', CustomerServicesCart::class)->name('customer-service-cart');
        Route::get('services', CustomerServicesList::class)->name('customer-services');
        Route::prefix('orders')->group(function () {
            Route::get('cancelled', CustomerCancelledOrder::class)->name('customer-order-cancelled');
            Route::get('completed', CustomerCompleteOrder::class)->name('customer-order-completed');
            Route::get('confirmed', CustomerConfirmedOrder::class)->name('customer-order-confirmed');
            Route::get('declined', CustomerDeclinedOrder::class)->name('customer-order-declined');
            Route::get('orderlist', CustomerOrderList::class)->name('customer-order-list');
            Route::get('pending', CustomerPendingOrder::class)->name('customer-order-pending');
            Route::get('ready-for-pickup', CustomerReadyForPickup::class)->name('customer-order-ready-for-pickup');
        });
        Route::get('products', CustomerProducts::class)->name('customer-product');
        Route::get('profile', CustomerProfile::class)->name('customer-profile');
        Route::prefix('services')->group(function () {
            Route::get('service-list', CustomerServicesAll::class)->name('customer-service-list');
            Route::get('approved', CustomerServicesApproved::class)->name('customer-service-approved');
            Route::get('cancelled', CustomerServicesCancelled::class)->name('customer-service-cancelled');
            Route::get('completed', CustomerServicesCompleted::class)->name('customer-service-completed');
            Route::get('declined', CustomerServicesDeclined::class)->name('customer-service-declined');
            Route::get('ready-to-pick-up',CustomerServicesReadyToPickUp::class)->name('customer-service-rtpi');
            Route::get('pending', CustomerServicesPending::class)->name('customer-service-pending');

        });
        Route::get('trackorder', CustomerTrackOrder::class)->name('customer-track-order');
        Route::get('/contact',CustomerContact::class)->name('customer-contact');
    });
});

