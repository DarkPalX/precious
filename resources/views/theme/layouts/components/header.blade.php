<header id="header" class="dark header-size-sm" data-sticky-shrink="false">
	<div class="container">
		<div class="header-row">

			<!-- Logo
			============================================= -->
			<div id="logo">
				<a href="{{ route('home') }}" class="standard-logo" data-dark-logo="{{ Setting::get_company_logo_storage_path() }}"><img src="{{ Setting::get_company_logo_storage_path() }}" alt="{{ Setting::info()->company_name }} Logo"></a>
				<a href="{{ route('home') }}" class="retina-logo" data-dark-logo="{{ Setting::get_company_logo_storage_path() }}"><img src="{{ Setting::get_company_logo_storage_path() }}" alt="{{ Setting::info()->company_name }} Logo"></a>
			</div><!-- #logo end -->

			@if(Auth::check())
				<ul class="nav border-0">
					@if(isset(auth()->user()->avatar))
						<img src="{{ auth()->user()->avatar }}" class="alignleft img-circle img-thumbnail m-0" alt="Avatar" style="max-width: 42px;">
					@else
						<img src="{{ asset('images/user.png') }}" class="alignleft img-circle img-thumbnail m-0" alt="Avatar" style="max-width: 42px;">
					@endif
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white ps-2" data-bs-toggle="dropdown" href="#">
						Welcome {{auth()->user()->fullname}}
						</a>
						<ul class="dropdown-menu" role="menu">
							<a class="dropdown-item" href="{{ route('customer.manage-account') }}">Manage my Account</a>
							<a class="dropdown-item" href="{{ route('profile.sales') }}">My Transactions</a>
							{{-- <a class="dropdown-item" href="#">My Library</a> --}}
							<a class="dropdown-item" href="{{ env('APP_URL').'/contact-us' }}">Contact Us</a>
							<a class="dropdown-item" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
						</ul>
					</li>
				</ul>
			@else
				<div class="header-buttons d-none d-sm-inline-block">								
					<a href="#modal-register" data-lightbox="inline" class="button button-rounded button-white button-light button-small m-0">Log In</a>
				</div>
			@endif
		</div>
	</div>

	<div id="header-wrap">
		<div class="container">
			<div class="header-row justify-content-between flex-row-reverse flex-lg-row">

				<div class="header-misc">

					<!-- Top Search
					============================================= -->
					<div id="top-search" class="header-misc-icon">
						<a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i class="icon-line-cross"></i></a>
					</div><!-- #top-search end -->
					
					@if(!Str::contains(url()->current(), '/cart'))
						<div id="top-cart" class="header-misc-icon">
							<a href="javascript:;" class="side-panel-trigger">
								<i class="icon-line-bag"></i>
								<span class="top-cart-number bg-danger">{{ Setting::EcommerceCartTotalItems() }}</span>
							</a>
						</div>
					@endif
					
					<!-- Login Modal -->
					<div class="modal1 mfp-hide" id="modal-register">
						<div class="card mx-auto" style="max-width: 540px;">
							<div class="card-header py-3 bg-transparent center">
								<h3 class="mb-0 fw-normal">Hello, Welcome Back</h3>
							</div>
							<div class="card-body mx-auto py-5" style="max-width: 70%;">

								@include('theme.layouts.components.third-party-signin')

								<form id="login-form" name="login-form" class="mb-0 row" action="{{ route('customer-front.customer_login') }}" method="post">
									@csrf
									<div class="col-12">
										<input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Enter Email" />
									</div>

									<div class="col-12 mt-4">
										<!-- <input type="password" id="login-form-password" name="login-form-password" value="" class="form-control not-dark" placeholder="Password" /> -->
										<div class="input-group show_hide_password" id="show_hide_password">
                                            <input class="form-control" type="password" name="password" placeholder="Password">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><a href=""><i class="icon icon-eye-slash" aria-hidden="true"></i></a></span>
                                            </div>
                                        </div>
									</div>

									<div class="col-12">
										<a href="#modal-forgot-password" data-lightbox="inline" class="float-end text-dark fw-light mt-2">Forgot Password?</a>
									</div>

									<div class="col-12 mt-4">
										<button type="submit" class="button w-100 m-0 center" value="login">Login</button>
									</div>
								</form>
							</div>
							<div class="card-footer py-4 center">
								{{-- <p class="mb-0">Don't have an account? <a href="{{ route('customer-front.customer-sign-up') }}"><u>Sign up</u></a></p> --}}
								<p class="mb-0">Don't have an account? <a href="#modal-signup" data-lightbox="inline"><u>Sign up</u></a></p>
							</div>
						</div>
					</div>

					<!-- Forgot Password Modal -->
					<div class="modal1 mfp-hide" id="modal-forgot-password">
						<div class="card mx-auto" style="max-width: 540px;">
							<div class="card-header py-3 bg-transparent center">
								<h3 class="mb-0 fw-normal">Recover Password</h3>
							</div>
							<div class="card-body mx-auto py-5" style="max-width: 70%;">

								<form id="forgot-password-form" name="forgot-password-form" class="mb-0 row" action="{{ route('customer-front.send_reset_link_email') }}" method="post">
									@csrf
									<p>Enter email to reset password.</p>
									<div class="col-12">
										<input type="email" id="email" name="email" class="form-control not-dark" placeholder="Email" required/>
									</div>

									<div class="col-12">
										<a href="#modal-register" data-lightbox="inline" class="float-end text-dark fw-light mt-2">Back to login</a>
									</div>

									<div class="col-12 mt-4">
										<button type="submit" class="button w-100 m-0 center" id="login-form-submit" name="login-form-submit" value="login">Reset</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- Signup Modal -->
					<div class="modal1 mfp-hide" id="modal-signup">
						<div class="card mx-auto" style="max-width: 540px;">
							<div class="card-header py-3 bg-transparent center">
								<h3 class="mb-0 fw-normal">Sign up</h3>
							</div>
							<div class="card-body mx-auto py-5" style="max-width: 70%;">

								<form id="register-form" name="register-form" class="row mb-0" action="{{ route('customer-front.customer-sign-up') }}" method="post">
									@csrf

									<div class="col-12">
										<input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" class="form-control not-dark @error('firstname') is-invalid @enderror" placeholder="Firstname" />
										@error('firstname')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
									
									<div class="col-12 mt-3">
										<input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" class="form-control not-dark @error('lastname') is-invalid @enderror" placeholder="Lastname" />
										@error('lastname')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
									
									<div class="col-12 mt-3">
										<input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control not-dark @error('email') is-invalid @enderror" placeholder="Email Address" />
										@error('email')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
									
									<div class="col-12 mt-3">
										<input type="number" id="mobile" name="mobile" min="0" value="{{ old('mobile') }}" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);" class="form-control not-dark @error('mobile') is-invalid @enderror" placeholder="Mobile Number" />
										@error('mobile')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
									
									{{-- <div class="col-12 mt-3">
										<input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control not-dark @error('password') is-invalid @enderror" placeholder="Password" />
										@error('password')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
									
									<div class="col-12 mt-3">
										<input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control not-dark @error('password_confirmation') is-invalid @enderror" placeholder="Re-enter Password" />
										@error('password_confirmation')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div> --}}

									<div class="col-12 mt-3">
										<button class="button w-100 m-0 center" id="" name="" value="login">Sign up</button>
										
										<a href="#modal-register" data-lightbox="inline" class="button w-100 m-0 center mt-3 button-dark">Back</a>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>

				<div id="primary-menu-trigger">
					<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
				</div>

				<!-- Primary Navigation
				============================================= -->
				<nav class="primary-menu with-arrows">
					@include('theme.layouts.components.menu')
				</nav><!-- #primary-menu end -->

				<form method="GET" action="{{route('search.result')}}" class="top-search-form">
					<input type="text" name="searchtxt" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off" aria-describedby="button-addon2">
					<button class="btn btn-outline-primary btn-primary" type="submit" id="button-addon2" hidden><i class="icon-search text-white"></i></button>
				</form>

			</div>
			
			{{-- @if(Setting::hasItemThreeDaysOnCart())
				<div class="alert alert-warning alert-dismissible alert-xs fade show mt-2" role="alert">
					<strong>Check your cart!</strong> there are items left for 3 days. Please take an action before the system automatically delete the item/s.
				</div>
			@endif --}}
			
			@if(Setting::hasItemsLeftOnCart())
				<div class="alert alert-warning alert-dismissible alert-xs fade show mt-2" role="alert">
					<strong>Check your cart!</strong> there are items left for ({{  \App\Models\Setting::first()->cart_notification_duration }}) hours. Please take an action before the system automatically delete the item/s.
				</div>
			@endif

		</div>
	</div>
	<div class="header-wrap-clone"></div>
</header>

@include('theme.layouts.components.alert')