<div>
    <div class="navbar-container">
    <nav class="navbar" style="background-color: #8d021f; ">
        <a href="#" class="sidebar-toggler">
            <i data-feather="menu"></i>
        </a>
        <div class="navbar-content">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="bell"></i>
                        <div class="indicator">
                            <div class="circle"></div>
                        </div>
                        {{$header_info['notifications_count']}} 
                    </a>
                    <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
                        <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                            <p class=" pt-3 pb-0">{{$header_info['notifications_count']}} New Notifications</p>
                        </div>
                        <div class="p-1">
                            @foreach($header_info['notifications_list'] as $key => $value)
                                @if($value->is_read == 0 ) 
                                    <a  href="{{$value->notification_link}}" style="max-height:70px" class="dropdown-item d-flex align-items-center py-2 bg-danger  ">
                                        <div class="d-flex align-items-center justify-content-center  rounded-circle mx-3 text-white" style="max-width:24px;max-heigh:24px">
                                            <?php echo $value->notification_icon ?>
                                        </div>
                                        <div class="flex-grow-1 me-2">
                                            <p class="p-0 m-0 text-white" > {{$value->notification_content}}</p>
                                            <p class="tx-12 p-0 m-0  text-success">   <?php echo(self::timeAgo($value->date_created)); ?> </p>
                                        </div>	
                                        <button wire:click="update_is_read({{$value->id}},1)" class="btn btn-outline-secondary text-white" >
                                            mark as read
                                        </button>
                                    </a>
                                @else
                                    <a href="{{$value->notification_link}}" style="max-height:70px" class="dropdown-item d-flex align-items-center py-2 ">
                                        <div class="d-flex align-items-center justify-content-center  rounded-circle mx-3 text-white" style="max-width:24px;max-heigh:24px">
                                            <?php echo $value->notification_icon ?>
                                        </div>
                                        <div class="flex-grow-1 me-2">
                                            <p class="p-0 m-0"> {{$value->notification_content}}</p>
                                            <p class="tx-12 p-0 m-0 text-success">   <?php echo(self::timeAgo($value->date_created)); ?> </p>
                                        </div>
                                        <button wire:click="update_is_read({{$value->id}},0)" class="btn btn-outline-secondary text-white">
                                            mark as unread
                                        </button>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        <!-- <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                            <a href="javascript:;">View all</a>
                        </div> -->
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="wd-30 ht-30 rounded-circle"  src="{{asset('storage/content/profile/'.$user_info->image) }}" alt="profile">
                    </a>
                    <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                        <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                            <div class="mb-3">
                                <img class="wd-80 ht-80 rounded-circle" src="{{asset('storage/content/profile/'.$user_info->image) }}" alt="">
                            </div>
                            <div class="text-center">
                                <p class="tx-16 fw-bolder"></p>
                                <p class="tx-12 text-muted"></p>
                            </div>
                        </div>
                        <ul class="list-unstyled p-1">
                            <li class="dropdown-item py-2">
                                <a href="{{ route('admin-profile') }}" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                                </a>
                            </li>
                            <li class="dropdown-item py-2">
                                <a href="{{ route('logout') }}" class="text-body ms-0">
                                    <i class="me-2 icon-md" data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div>