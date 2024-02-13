<header id="header" class="dark header-size-sm" data-sticky-shrink="false">
	<div class="container">
		<div class="header-row">

			<!-- Logo
			============================================= -->
			<div id="logo">
				<a href="{{ route('home') }}" class="standard-logo" data-dark-logo="{{ Setting::get_company_logo_storage_path() }}"><img src="{{ Setting::get_company_logo_storage_path() }}" alt="Precious Pages Logo"></a>
				<a href="{{ route('home') }}" class="retina-logo" data-dark-logo="{{ Setting::get_company_logo_storage_path() }}"><img src="{{ Setting::get_company_logo_storage_path() }}" alt="Precious Pages Logo"></a>
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
							<a class="dropdown-item" href="#">My Library</a>
							<a class="dropdown-item" href="#">Contact Us</a>
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
					
					<div id="top-cart" class="header-misc-icon">
						<a href="javascript:;" class="side-panel-trigger"><i class="icon-line-bag"></i><span class="top-cart-number bg-danger">{{ Setting::EcommerceCartTotalItems() }}</span></a>
					</div>
					
					<!-- Login Modal -->
					<div class="modal1 mfp-hide" id="modal-register">
						<div class="card mx-auto" style="max-width: 540px;">
							<div class="card-header py-3 bg-transparent center">
								<h3 class="mb-0 fw-normal">Hello, Welcome Back</h3>
							</div>
							<div class="card-body mx-auto py-5" style="max-width: 70%;">

								<a href="#" class="button button-large w-100 si-colored si-facebook nott fw-normal ls0 center m-0 mb-2"><i class="icon-facebook-sign"></i> Log in with Facebook</a>
								<a href="#" class="button button-large w-100 si-colored si-google nott fw-normal ls0 center m-0"><i class="icon-google"></i> Log in with Google</a>

								<div class="divider divider-center"><span class="position-relative" style="top: -2px">OR</span></div>

								<form id="login-form" name="login-form" class="mb-0 row" action="{{ route('customer-front.customer_login') }}" method="post">
									@csrf
									<div class="col-12">
										<input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Enter Email" />
									</div>

									<div class="col-12 mt-4">
										<!-- <input type="password" id="login-form-password" name="login-form-password" value="" class="form-control not-dark" placeholder="Password" /> -->
										<div class="input-group show_hide_password" id="show_hide_password">
                                            <input class="form-control" type="password" name="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><a href=""><i class="icon icon-eye-slash" aria-hidden="true"></i></a></span>
                                            </div>
                                        </div>
									</div>

									<div class="col-12">
										<a href="#" class="float-end text-dark fw-light mt-2">Forgot Password?</a>
									</div>

									<div class="col-12 mt-4">
										<button type="submit" class="button w-100 m-0 center" value="login">Login</button>
									</div>
								</form>
							</div>
							<div class="card-footer py-4 center">
								<p class="mb-0">Don't have an account? <a href="{{ route('customer-front.customer-sign-up') }}"><u>Sign up</u></a></p>
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

				<form class="top-search-form" action="search.html" method="get">
					<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
				</form>

			</div>
		</div>
	</div>
	<div class="header-wrap-clone"></div>
</header>