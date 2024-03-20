@extends('theme.main')

@section('pagecss')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div class="container topmargin-lg bottommargin-lg">	
	<div class="row">
			<div id="processTabs" data-plugin="tabs" class="customjs">
			{{-- <div id="processTabs"> --}}
			{{-- <ul class="process-steps row col-mb-30">
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab1" class="i-circled i-bordered i-alt mx-auto btn_ptab1">1</a>
					<h5>Billing Information</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab2"><button class="i-circled i-bordered i-alt mx-auto tab-linker tab-linker-top btn_ptab2" rel="2">2</button></a>
					<h5>Shipping Options</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab3"><button type="button" class="i-circled i-bordered i-alt mx-auto tab-linker tab-linker-top btn_ptab3" rel="2">3</button></a>
					<h5>Payment Method</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab4"><button type="button" class="i-circled i-bordered i-alt mx-auto tab-linker tab-linker-top btn_ptab4" rel="2">4</button></a>
					<h5>Review and Place Order</h5>
				</li>
			</ul> --}}
			<ul class="process-steps row col-mb-30">
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab1" class="i-circled i-bordered tab-linker i-alt mx-auto">1</a>
					<h5>Billing Information</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab2" class="i-circled i-bordered tab-linker i-alt mx-auto">2</a>
					<h5>Shipping Options</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab3" class="i-circled i-bordered tab-linker i-alt mx-auto">3</a>
					<h5>Payment Method</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab4" class="i-circled i-bordered tab-linker i-alt mx-auto">4</a>
					<h5>Review and Place Order</h5>
				</li>
			</ul>
			<form method="post" action="{{ route('cart.temp_sales') }}" id="chk_form">
				@csrf
				<div id="ptab1">
					<h2>Billing Information</h2>

					<table class="table table-hover">
						<tbody>
							<tr>
								<td width="20%">Name</td>
								<td>{{$customer->firstname}} {{$customer->lastname}}</td>
							</tr>
							<tr>
								<td>Email Address</td>
								<td>{{$customer->email}}</td>
							</tr>
							<tr>
								<td>Contact Number</td>
								<td>{{$customer->mobile}}</td>
							</tr>
							<tr>
								<td>Address</td>
								<td>{{$customer->address_street}}, {{$customer->address_city}}, {{$customer->address_province}}</td>
							</tr>
							<tr>
								<td>Zip Code</td>
								<td>{{$customer->address_zip}}</td>
							</tr>
						</tbody>
					</table>

					<br>
					<a href="{{ env('APP_URL') }}/checkout" class="btn btn-dark float-end tab-linker" rel="2">
						Next <i class="icon icon-circle-arrow-right"></i>
					</a>
					{{-- <a href="#" class="btn bg-color text-white tab-linker float-end" rel="2" onclick="update_details();">Next <i class="icon-arrow-circle-right"></i></a> --}}
				</div>

				
				<div id="ptab2">
					<h2>Shipping Options</h2>
					
					<div class="row">
						<div class="col-md-8">
							<div class="row justify-content-center">
								<label for="data-plan-starter" class="col-sm-6 col-md-4">
									<div class="pricing-box text-center shadow-none border">
										<input type="radio" name="data-plans-selected" class="required mt-3" id="data-plan-starter" autocomplete="off" data-price="30" value="Starter">
										<div class="pricing-price">
											<h3 class="nott ls0 mb-0">Door-to-Door</h3>
										</div>
										<div class="px-3">
											<p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										</div>
									</div>
								</label>

								<label for="data-plan-professional" class="col-sm-6 col-md-4">
									<div class="pricing-box text-center shadow-none border">
										<input type="radio" name="data-plans-selected" class="required mt-3" id="data-plan-professional" autocomplete="off" data-price="30" value="Professional">
										<div class="pricing-price">
											<h3 class="nott ls0 mb-0">For Pickup</h3>
										</div>
										<div class="px-3">
											<p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										</div>
									</div>
								</label>

								<label for="data-plan-business" class="col-sm-6 col-md-4">
									
								</label>
							</div>
						</div>
						
						<div class="col-md-4">
							<div id="row">
								<div class="input-group">
									<input type="text" class="form-control m-input" placeholder="Enter Coupon Code..">
								</div>
								<a href="#" class="small mb-3 d-inline-block" data-bs-toggle="modal" data-bs-target="#myModal">Apply Coupon</a>

								<!-- Modal -->
								<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myModalLabel">My Coupon</h4>
												<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
											</div>
											<div class="modal-body">
												<table class="table small border rounded border-top-warning">
													<tbody>
														<tr>
															<td>
																<h3 class="mb-0">16.00% OFF</h3>
																For orders over ₱100.00
																<br><br>
																Code: ph5b11v2
																<br>Coupon requirements met, expect to save ₱217.00
																<br><br>
																<div class="text-secondary">
																	<ul class="m-0 ms-3">
																		<li>11/04/2023 - 11/11/2023</li>	
																		<li>Applies to select products</li>	
																	</ul>
																</div>
															</td>
															<td width="10px">
																<label>
																	<input type="radio" name="car-rental-selected-car" class="required" id="car-rental-cars-creta" autocomplete="off" data-price="30" value="Creta"> 
																</label>
															</td>
														</tr>
													</tbody>
												</table>

												<table class="table small border rounded">
													<tbody>
														<tr>
															<td>
																<h3 class="mb-0">₱140.00 OFF</h3>
																For orders over ₱3,499.00
																<br><br>
																Code: ph1111s
																<br>Coupon requirements met, expect to save ₱140.00
																<br><br>
																<div class="text-secondary">
																	<ul class="m-0 ms-3">
																		<li>11/04/2023 - 11/11/2023</li>	
																		<li>Applies to select products</li>	
																	</ul>
																</div>
															</td>
															<td width="10px">
																<label>
																	<input type="radio" name="car-rental-selected-car" class="required" id="car-rental-cars-creta" autocomplete="off" data-price="30" value="Creta"> 
																</label>
															</td>
														</tr>
													</tbody>
												</table>


											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
												<button type="button" class="btn btn-primary">Apply</button>
											</div>
										</div>
									</div>
								</div>

								<table class="table small border rounded border-top-warning">
									<tbody>
										<tr>
											<td>
												<h3 class="mb-0">16.00% OFF</h3>
												For orders over ₱100.00
												<br><br>
												Code: ph5b11v2
												<br>Coupon requirements met, expect to save ₱217.00
												<br><br>
												<div class="text-secondary">
													<ul class="m-0 ms-3">
														<li>11/04/2023 - 11/11/2023</li>	
														<li>Applies to select products</li>	
													</ul>
												</div>
											</td>
											<td width="10px">
												<a href="#"><span class="icon icon-times"></span></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div id="newinput"></div>
							<button id="rowAdder" type="button" class="btn btn-dark">
								<span class="icon icon-plus-square1"></span> Add Coupon
							</button>
						</div>
					</div>
					
					<br>
					<a href="checkout.htm" class="btn btn-dark tab-linker " rel="1">
						<i class="icon icon-circle-arrow-left"></i> Previous 
					</a>
					<a href="checkout.htm" class="btn btn-dark float-end tab-linker " rel="3">
						Next <i class="icon icon-circle-arrow-right"></i>
					</a>
					
				</div>

				<div id="ptab3">
					<h2>Payment Method</h2>
					
					<div class="tabs tabs-responsive clearfix">

						<ul class="tab-nav clearfix">
							<li><a href="#tab-responsive-1">Credit / Debit Card</a></li>
							<li><a href="#tab-responsive-2">Gcash</a></li>
							<li><a href="#tab-responsive-3">Alipay</a></li>
							<li class="d-none d-md-block"><a href="#tab-responsive-4">Beep Card</a></li>
						</ul>

						<div class="tab-container">

							<div class="tab-content clearfix" id="tab-responsive-1">
								Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.
							</div>
							<div class="tab-content clearfix" id="tab-responsive-2">
								Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.
							</div>
							<div class="tab-content clearfix" id="tab-responsive-3">
								<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
								Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.
							</div>
							<div class="tab-content clearfix" id="tab-responsive-4">
								Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.
							</div>

						</div>

					</div>
					
					<br>
					<a href="checkout.htm" class="btn btn-dark tab-linker " rel="2">
						<i class="icon icon-circle-arrow-left"></i> Previous 
					</a>
					<a href="checkout.htm" class="btn btn-dark float-end tab-linker " rel="4">
						Next <i class="icon icon-circle-arrow-right"></i>
					</a>
				</div>

				<div id="ptab4">
					<h2>Review and Place Order</h2>
					
					<table class="table">
						<tbody>
						<tr>
							<td width="20%"><small>Billed to</small></td>
						</tr>
						<tr>
							<td>
								<h3 class="m-0">Stephen Curry</h3>
								curry@emailaddress.com
								<br>123-4567
								<br>Lorem ipsum dolor sit amet, consectetur adipisicing elit
								<br>1611
							</td>
						</tr>
						</tbody>
					</table>
					
					<table class="table cart mb-5">
						<thead>
							<tr>
								<th class="cart-product-thumbnail">&nbsp;</th>
								<th class="cart-product-name">Product</th>
								<th class="cart-product-price">Unit Price</th>
								<th class="cart-product-quantity">Quantity</th>
								<th class="cart-product-subtotal">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr class="cart_item">
								<td class="cart-product-thumbnail">
									<a href="#"><img width="64" height="64" src="images/products/image1.png" alt="Pink Printed Dress"></a>
								</td>

								<td class="cart-product-name">
									<a href="#">Pink Printed Dress</a>
								</td>

								<td class="cart-product-price">
									<span class="amount">$19.99</span>
								</td>

								<td class="cart-product-quantity">
									<div class="quantity">
										2
									</div>
								</td>

								<td class="cart-product-subtotal">
									<span class="amount">$39.98</span>
								</td>
							</tr>
							<tr class="cart_item">
								<td class="cart-product-thumbnail">
									<a href="#"><img width="64" height="64" src="images/products/image2.png" alt="Checked Canvas Shoes"></a>
								</td>

								<td class="cart-product-name">
									<a href="#">Checked Canvas Shoes</a>
								</td>

								<td class="cart-product-price">
									<span class="amount">$24.99</span>
								</td>

								<td class="cart-product-quantity">
									<div class="quantity">
										2
									</div>
								</td>

								<td class="cart-product-subtotal">
									<span class="amount">$24.99</span>
								</td>
							</tr>
							<tr class="cart_item">
								<td class="cart-product-thumbnail">
									<a href="#"><img width="64" height="64" src="images/products/image3.png" alt="Pink Printed Dress"></a>
								</td>

								<td class="cart-product-name">
									<a href="#">Blue Men Tshirt</a>
								</td>

								<td class="cart-product-price">
									<span class="amount">$13.99</span>
								</td>

								<td class="cart-product-quantity">
									<div class="quantity">
										2
									</div>
								</td>

								<td class="cart-product-subtotal">
									<span class="amount">$41.97</span>
								</td>
							</tr>
						</tbody>
					</table>
					
					<div class="row">
						<div class="col-md-6">
							<p class="text-danger">Notes</p>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
						</div>
						<div class="col-md-6">
							<h4>Cart Totals</h4>

							<div class="table-responsive">
								<table class="table cart cart-totals">
									<tbody>
										<tr class="cart_item">
											<td class="cart-product-name">
												<strong>Cart Subtotal</strong>
											</td>

											<td class="cart-product-name text-end">
												<span class="amount">$106.94</span>
											</td>
										</tr>
										<tr class="cart_item">
											<td class="cart-product-name">
												<strong>Voucher</strong>
											</td>

											<td class="cart-product-name text-end"></td>
										</tr>
										<tr class="cart_item">
											<td colspan="2">
												<table class="table m-0">
													<tbody>
														<tr>
															<td>dsfdsfsd</td>
															<td class="text-end">300</td>
														</tr>
														<tr>
															<td>dsfdsfsd</td>
															<td class="text-end">300</td>
														</tr>
														<tr>
															<td>dsfdsfsd</td>
															<td class="text-end">300</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr class="cart_item">
											<td class="cart-product-name">
												<strong>Total Voucher</strong>
											</td>

											<td class="cart-product-name text-end">
												<span class="amount">$106.94</span>
											</td>
										</tr>
										<tr class="cart_item">
											<td class="cart-product-name">
												<strong>Shipping</strong>
											</td>

											<td class="cart-product-name text-end">
												<span class="amount">Free Delivery</span>
											</td>
										</tr>
										<tr class="cart_item">
											<td colspan="2">
												<table class="table m-0">
													<tbody>
														<tr>
															<td>dsfdsfsd</td>
															<td class="text-end">300</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr class="cart_item">
											<td class="cart-product-name">
												<strong>Total Shipping Voucher</strong>
											</td>

											<td class="cart-product-name text-end">
												<span class="amount">$106.94</span>
											</td>
										</tr>
										<tr class="cart_item">
											<td class="cart-product-name">
												<strong>My E-Wallet</strong>
											</td>

											<td class="cart-product-name text-end">
												<span class="amount">$106.94</span>
											</td>
										</tr>
										<tr class="cart_item">
											<td class="cart-product-name">
												<strong>Total</strong>
											</td>

											<td class="cart-product-name text-end">
												<span class="amount color lead"><strong>$106.94</strong></span>
											</td>
										</tr>
									</tbody>

								</table>
							</div>
						</div>
					</div>
					
					<br>								
					<a href="checkout.htm" class="btn btn-dark tab-linker " rel="3">
						<i class="icon icon-circle-arrow-left"></i> Previous 
					</a>
					<a href="success.htm" class="btn btn-dark float-end">
						Complete Order <i class="icon icon-circle-arrow-right"></i>
					</a>
				</div>
			</form>
		</div>
	</div>	
</div>
@endsection

@section('pagejs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
	jQuery(window).on( 'pluginTabsReady', function(){
		$( "#processTabs" ).tabs({ show: { effect: "fade", duration: 400 } });
		$( ".tab-linker" ).click(function() {
			$( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
			return false;
		});
	});
</script>

<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover();
	});

	function IsEmail(email) {
	    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	    if(!regex.test(email)) {
	        return false;
	    } else{
	        return true;
	    }
	}


	// $(function() {

	// 	$( "#processTabs" ).tabs({ show: { effect: "fade", duration: 400 } });
	// 	$( ".tab-linker" ).click(function() {
	// 		var nxt_tab = $(this).attr('rel');
			
	// 		if(nxt_tab == 2){
	// 			var fname = $('#customer_fname').val();
	// 			var lname = $('#customer_lname').val();
	// 			var email = $('#customer_email').val();
	// 			var contact = $('#customer_contact_number').val();
	// 			var brgy = $('#customer_delivery_barangay').val();
	// 			var city = $('#customer_delivery_city').val();
	// 			var province = $('#customer_delivery_province').val();
	// 			var zipcode = $('#customer_delivery_zip').val();

	// 			if(fname.length === 0 || lname.length === 0 || contact.length === 0 || IsEmail(email) == false || zipcode.length === 0 || brgy.length === 0 || city.length === 0 || province.length === 0){
    //                 swal('Oops...', 'Please check required input fields.', 'error');
					
	// 	            return false;

    //             } else {
    //                 $( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
	// 				return false;
    //             }
	// 		} else if(nxt_tab == 3){

	//    			var sfOption = $('#shippingOption').val();

	//             $( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
	// 			return false;

	// 		} else {
	// 			$( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
	// 			return false;
	// 		}	
	// 	});
	// });

	function update_details(){
		var customer = $('#customer_fname').val()+' '+$('#customer_lname').val();
		var email = $('#customer_email').val();
		var contact = $('#customer_contact_number').val();
		var address = $('#customer_delivery_barangay').val()+' '+$('#customer_delivery_city').val()+' '+$('#customer_delivery_province').val();
		var zipcode = $('#customer_delivery_zip').val();
		var notes   = $('#other_instruction').val();
		
		$('#ck_billed_to').html(customer);
		$('#ck_email').html(email);
		$('#ck_contact').html(contact);
		$('#ck_address').html(address);
		$('#ck_zip').html(zipcode);
		$('#ck_notes').html(notes);
	}

	function addCommas(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

	function shipping_type(stype){
		$('#shippingOption').val(stype);
	}

    function compute_total(){

        var delivery_fee = parseFloat($('#delivery_fee').val());
        var delivery_discount = parseFloat($('#sf_discount_amount').val());


        var orderAmount = parseFloat($('#totalAmountWithoutCoupon').val());
        var couponDiscount = parseFloat($('#coupon_total_discount').val());

        var orderTotal  = orderAmount-couponDiscount;
        var deliveryFee = delivery_fee-delivery_discount;

        var grandTotal = parseFloat(orderTotal)+parseFloat(deliveryFee);

        $('#span_total_amount').html(addCommas(parseFloat(grandTotal).toFixed(2)));
        $('#total_amount').val(grandTotal.toFixed(2));
    }

    function place_order() {   
	    $('#chk_form').submit();
	}
</script>
@endsection