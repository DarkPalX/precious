@php
    $contents = Setting::getFooter()->contents;

    $socmed = \App\Models\MediaAccounts::all();

    $socmedHTML = '<div class="mt-4 clearfix">';
    	foreach($socmed as $sm){
    		$socmedHTML .= '
    			<a href="'.$sm->media_account.'" class="social-icon si-small si-rounded si-colored si-'.$sm->name.'" title="'.$sm->name.'" target="_blank">
	                <i class="icon-'.$sm->name.'"></i>
	                <i class="icon-'.$sm->name.'"></i>
	            </a>
    		';
    	}

    $socmedHTML .= '</div>';


    $keywords   = ['{Social Media Icons}'];
    $variables  = [$socmedHTML];

    $footerContents = str_replace($keywords,$variables,$contents);
@endphp


{!! $footerContents !!}



<!-- Subscribe Form modal
============================================= -->
<div class="modal1 mfp-hide" id="modal-subscribe">
	<div class="card mx-auto" style="max-width: 540px;">
		<div class="card-body" style="background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.3)), url('{{ asset('images/misc/subscribe.jpeg') }}') no-repeat center center / cover; padding: 60px 50px; border: 12px solid #FFF">
			<div class="d-flex justify-content-between">
				<h2 class="card-title text-white font-body">Subscribe to our Newsletter!</h2>
			</div>
			<p class="text-light">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum nisi beatae temporibus nobis optio eos?</p>

			<div class="subscribe-widget" data-loader="button">

				<div class="widget-subscribe-form-result"></div>

				<form action="include/subscribe.php" role="form" method="post" class="mb-0">
					@csrf
					<label for="widget-subscribe-form-email" class="text-light">Name <span>*</span></label>
					<input type="text" name="name" id="subscriber_name" class="form-control required not-dark" placeholder="your name">

					<label for="email" class="text-light">Email Address <span>*</span></label>
					<input type="email" name="email" id="subscriber_email" class="form-control required not-dark" placeholder="name@email.com">

					<button class="btn rounded btn-danger py-2 mt-3 w-100 text-uppercase ls1 fw-semibold" type="submit">Subscribe</button>
				</form>

			</div>
		</div>
	</div>
</div>
<!-- Subscribe form end modal -->


@section('pagejs')
	<script>
		$(document).ready(function() {
			// Set the initial value on page load
			$('#subscriber_email').val($('#widget-subscribe-form-email').val());

			// Update the value on user input
			$('#widget-subscribe-form-email').on('input', function() {
				$('#subscriber_email').val($(this).val());
			});
		});
	</script>
@endsection