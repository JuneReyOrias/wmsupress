<div>
    <div class="col-md-12">
        <div class="filters">
            <ul>
                <a href="{{route('customer-order-list')}}" style="text-decoration:none;">
                    <li data-status="all" @if( Route::is('customer-order-list')) class="active" @endif">
                        All Orders
                    </li>
                </a>
                <a href="{{route('customer-order-cancelled')}}" style="text-decoration:none;">
                    <li data-status="Declined" @if( Route::is('customer-order-cancelled')) class="active" @endif">Cancelled</li>
                </a>
                <a href="{{route('customer-order-declined')}}" style="text-decoration:none;">
                    <li data-status="Declined" @if( Route::is('customer-order-declined')) class="active" @endif">Declined</li>
                </a>
                <a href="{{route('customer-order-pending')}}" style="text-decoration:none;">
                    <li data-status="Pending" @if( Route::is('customer-order-pending')) class="active" @endif">Pending</li>
                </a>
                <a href="{{route('customer-order-confirmed')}}" style="text-decoration:none;">
                    <li data-status="Confirmed" @if( Route::is('customer-order-confirmed')) class="active" @endif">Confirmed</li>
                </a>
                <a href="{{route('customer-order-ready-for-pickup')}}" style="text-decoration:none;">
                    <li data-status="Ready for pick up" @if( Route::is('customer-order-ready-for-pickup')) class="active" @endif">Ready for Pick Up</li>
                </a>
                <a href="{{route('customer-order-completed')}}" style="text-decoration:none;">
                    <li data-status="Orderslip" @if( Route::is('customer-order-completed')) class="active" @endif">Completed</li>
                </a>
            </ul>
        </div>
    </div>
</div>
