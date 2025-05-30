<!DOCTYPE html>
<html dir="ltr" lang="en-US">


<!-- Fresh Chat Plugin Code -->

<script
	src='//fw-cdn.com/11794505/4403633.js'
	chat='true'>

	// Copy the below lines under window.fcWidget.init inside fw_chat_widget function in the above snippet

	// To set unique user id in your system when it is available
	window.fcWidget.setExternalId("john.doe1987");

	// To set user name
	window.fcWidget.user.setFirstName("John");

	// To set user email
	window.fcWidget.user.setEmail("john.doe@gmail.com");

	// To set user properties
	// Note that any other fields passed as properties which are not in the CRM Contact properties already, they will be ignored.
	window.fcWidget.user.setProperties({
		cf_plan: "Pro",                 // meta property 1
		cf_status: "Active"             // meta property 2
	});
</script>

@include('theme.layouts.components.styles')

<body class="stretched">
	
	<!-- Cart Panel Background
	============================================= -->
	<div class="body-overlay"></div>


	@if(!Str::contains(url()->current(), '/cart'))
		@include('theme.layouts.components.shopping-cart-sidebar')
	@endif


	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		{{-- MODAL --}}
		@php
			$modal = \Setting::modals($page->name);
		@endphp

		@if($modal)
			<div class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">{{$modal->name}}</h4>
							<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">					
							{!!$modal->content!!}
						</div>
					</div>
				</div>
			</div>
		@endif
		
		{{--<div class="modal-on-load" data-target="#myModal1"></div>

		<!-- On LOad Modal -->
		<div class="modal1 mfp-hide subscribe-widget mx-auto" id="myModal1" style="max-width: 750px;">
			<div class="row justify-content-center bg-white align-items-center" style="min-height: 380px;">
				<div class="col-md-5 p-0">
					<div style="background: url('{{ asset('theme/images/products/image1.png')}}') no-repeat center right; background-size: cover;  min-height: 380px;"></div>
				</div>
				<div class="col-md-7 bg-white p-4">
					<div class="heading-block border-bottom-0 mb-3">
						<h3 class="font-secondary nott ">Join Our Newsletter &amp; Get <span class="text-danger">40%</span> Off your First Order</h3>
						<span>Get Latest Fashion Updates &amp; Offers</span>
					</div>
					<div class="widget-subscribe-form-result"></div>
					<form class="widget-subscribe-form2 mb-2" action="include/subscribe.php" method="post">
						<input type="email" id="widget-subscribe-form2-email" name="widget-subscribe-form-email" class="form-control required email" placeholder="Enter your Email Address..">
						<div class="d-flex justify-content-between align-items-center mt-1">
							<button class="button button-dark  bg-dark text-white ms-0" type="submit">Subscribe</button>
							<a href="#" class="btn-link text-danger" onClick="$.magnificPopup.close();return false;">Don't Show me</a>
						</div>
					</form>
					<small class="mb-0 fst-italic text-black-50">*We also hate Spam &amp; Junk Emails.</small>
				</div>
			</div>
		</div>--}}
		
		<!-- Top Bar
		============================================= -->
		@include('theme.layouts.top-bar')
		
		<!-- Header
		============================================= -->
		@include('theme.layouts.components.header')<!-- #header end -->

		<!-- Slider
		============================================= -->
		@include('theme.layouts.components.banner')
		
		<!-- #slider end -->

		<!-- Content
		============================================= -->
		<section id="website-content">
			@yield('content')
			
			{{-- BANNER ADS --}}
			@if(isset($banner_ads) && !$banner_ads->isEmpty())
				@foreach($banner_ads as $banner_ad)
					@php
						$files = json_decode($banner_ad->file_url, true) ?? [];
					@endphp

					<div class="section my-0" style="background-color:white;">
						<div class="container">
							<a href="{{ route('ads.click.count', $banner_ad->id) }}" target="_blank">
								<div id="carousel-{{ $banner_ad->id }}" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-inner">
										@foreach($files as $index => $file)
											<div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
												@if(Str::endsWith($file, ['.jpg', '.jpeg', '.png', '.gif']))
													{{-- Display image --}}
													<img src="{{ asset($file) }}" class="d-block w-100" alt="Ad Image" style="object-fit: cover; max-height: 400px;">
												@elseif(Str::endsWith($file, ['.mp4']))
													{{-- Display video --}}
													<video autoplay muted loop class="d-block w-100" style="object-fit: cover; max-height: 400px;">
														<source src="{{ asset($file) }}" type="video/mp4">
														Your browser does not support the video tag.
													</video>
												@endif
											</div>
										@endforeach
									</div>

									@if(count($files) > 1)
										{{-- Navigation Controls --}}
										<button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $banner_ad->id }}" data-bs-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="visually-hidden">Previous</span>
										</button>
										<button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $banner_ad->id }}" data-bs-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="visually-hidden">Next</span>
										</button>
									@endif
								</div>
							</a>
						</div>
					</div>
				@endforeach
			@endif
			{{-- @if(isset($banner_ads))
				@if(!$banner_ads->isEmpty())
					@foreach($banner_ads as $banner_ad)
						<div class="section my-0" style="background-color:white;">
							<div class="container">
								<a href="{{ route('ads.click.count', $banner_ad->id) }}" target="blank">
									<div class="text-center">
										<!-- for image -->
										<img src="{{ asset($banner_ad->file_url) }}" id="img_temp" alt="" style="display: {{ Str::contains($banner_ad->file_url, 'mp4') ? 'none' : '' }}">  <br /><br />
                        
										<!-- for video -->
										<video autoplay="" muted="" loop="" id="vid_temp" style="object-fit:none; display: {{ Str::contains($banner_ad->file_url, 'mp4') ? '' : 'none' }}">
											<source src="{{ asset($banner_ad->file_url) }}" type="video/mp4">
										</video>
									</div>
								</a>
							</div>
						</div>		
					@endforeach	
				@endif
			@endif --}}
			{{-- END BANNER ADS --}}
		
			<!-- CONTENT ADS
			============================================= -->
			@include('theme.layouts.content-ads')

		</section><!-- #content end -->

		<form id="logout-form" action="{{ route('account.logout') }}" method="get" style="display: none;">
	        @csrf
	    </form>
		
		<!-- Footer
		============================================= -->
		<footer id="footer" class="bg-transparent border-0">
			@include('theme.layouts.footer')
		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- Cookie
	============================================= -->
	<div class="alert text-center cookiealert" role="alert">
		<strong>Do you like cookies?</strong> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="#" target="_blank">Learn more</a>
		<button type="button" class="btn btn-primary btn-sm acceptcookies px-3" aria-label="Close">
			I agree
		</button>
	</div><!-- #cookie end -->
	

	{{-- /* FOR CAPTCHA */ --}}

	@include('theme.layouts.components.scripts')
	
	<!-- Google tag (gtag.js) -->
	{{-- <script async src="https://www.googletagmanager.com/gtag/js?id={{ Setting::info()->google_analytics }}"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', '{{ Setting::info()->google_analytics }}');
	</script> --}}

	{{-- /* FOR ANALYTICS */ --}}

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HR35693H16"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-HR35693H16');
	</script>



	<!-- Messenger Chat Plugin Code -->

	<div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "{{ env('FACEBOOK_PAGE_ID') }}");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : '{{ env('FACEBOOK_API_VERSION') }}'
        });

		FB.CustomerChat.show();

        FB.CustomerChat.update({
          logged_in_greeting: 'Hello There!',
          logged_out_greeting: 'Log in to Chat with Us',
          ref: 'coupon_15'
        });

        FB.Event.subscribe('customerchat.load', function() {
          console.log('Customer Chat Plugin has loaded');
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

</body>
</html>