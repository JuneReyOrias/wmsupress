<div>
    <div class="main-wrapper"style="  background-image: url(upload/wmsu.JPG); background-size: cover;    width: 100%; height: 100%; ">
		<div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">
				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto">
						<div class="card-register">
							<div class="row">
                                <!-- LOGIN PICTURE -->
                                <div class="col-md-4 pe-md-0">
                                    <div class="auth-side-wrapper">
                                        <!-- <img class="" src="{{url('assets')}}/logo/wmsu-logo.png" alt="University Logo"> -->
                                    </div>
                                </div>
                                <div class="col-md-8 ps-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="#" class="noble-ui-logo logo-light d-block mb-2">WMSU<span>UPRESS</span></a>
                                        <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                                        <form class="forms-sample" wire:submit="login()" >
                                            @csrf
                                            <div class="mb-3">
                                                <label for="login" class="form-label">Email address</label>
                                                <input  wire:model="user.email" class="form-control" type="email"  :value="old('email')" required autofocus autocomplete="username">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input  wire:model="user.password" class="form-control" type="password" required autocomplete="current-password">
                                                <div class="form-check mb-3">
                                                    <!-- <input type="checkbox" class="form-check-input"id="togglePasswordVisibilityCheckbox"> -->
                                                    <label class="form-check-label" for="togglePasswordVisibilityCheckbox">Show Password</label>
                                                </div>
                        
                                                @if($user['error'])
                                                    <div class="alert alert-danger">{{$user['error']}}</div>
                                                @endif
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                    Login
                                                </button>
                                            </div>
                                            <a href="{{route('page-homepage')}}" class="d-block mt-3 text-muted">Homepage</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script>
        document.getElementById("togglePasswordVisibilityCheckbox").addEventListener("change", function () {
            var passwordInput = document.getElementById("password");

            if (this.checked) {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    </script>
	<script src="../../../assets/vendors/core/core.js"></script>
	<script src="../../../assets/vendors/feather-icons/feather.min.js"></script>
	<script src="../../../assets/js/template.js"></script>
</div>
