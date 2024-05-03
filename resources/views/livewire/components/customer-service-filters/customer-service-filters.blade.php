<div>
    <div class="col-md-12">
        <div class="filters">
            <ul>
                <a href="{{route('customer-service-list')}}" style="text-decoration:none;">
                    <li data-status="all" @if( Route::is('customer-service-list')) class="active" @endif">
                        All Services
                    </li>
                </a>
                <a href="{{route('customer-service-cancelled')}}" style="text-decoration:none;">
                    <li data-status="Declined" @if( Route::is('customer-service-cancelled')) class="active" @endif">Cancelled</li>
                </a>
                <a href="{{route('customer-service-declined')}}" style="text-decoration:none;">
                    <li data-status="Declined" @if( Route::is('customer-service-declined')) class="active" @endif">Declined</li>
                </a>
                <a href="{{route('customer-service-pending')}}" style="text-decoration:none;">
                    <li data-status="Pending" @if( Route::is('customer-service-pending')) class="active" @endif">Pending</li>
                </a>
                <a href="{{route('customer-service-approved')}}" style="text-decoration:none;">
                    <li data-status="Approved" @if( Route::is('customer-service-approved')) class="active" @endif">Approved</li>
                </a>
                <a href="{{route('customer-service-rtpi')}}" style="text-decoration:none;">
                    <li data-status="rtpi" @if( Route::is('customer-service-rtpi')) class="active" @endif">Ready for Pickup</li>
                </a>
                <a href="{{route('customer-service-completed')}}" style="text-decoration:none;">
                    <li data-status="Completed" @if( Route::is('customer-service-completed')) class="active" @endif">Completed</li>
                </a>
            </ul>
        </div>
    </div>
</div>
