@extends('theme.main')

@section('pagecss')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div class="container topmargin-lg bottommargin-lg">	
	<div class="row">
		<div id="processTabs">
			<ul class="process-steps row col-mb-30">
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab1" class="i-circled i-bordered i-alt mx-auto">1</a>
					<h5>Billing Information</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab2" class="i-circled i-bordered i-alt mx-auto">2</a>
					<h5>Shipping Options</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab3" class="i-circled i-bordered i-alt mx-auto">3</a>
					<h5>Payment Method</h5>
				</li>
				<li class="col-sm-6 col-lg-3">
					<a href="#ptab4" class="i-circled i-bordered i-alt mx-auto">4</a>
					<h5>Review and Place Order</h5>
				</li>
			</ul>
			<form method="post" action="{{ route('cart.temp_sales') }}" id="chk_form">
				@csrf
				<div id="ptab1">
					<h2>Billing Information</h2>
					<table class="table table-borderless">
						<tbody>
							<tr>
								<td><strong>First Name</strong> <span class="text-danger">*</span></td>
								<td class="p-2" width="80%"><input type="text" class="form-control" name="customer_fname" id="customer_fname" value="{{$customer->firstname}}"></td>
							</tr>
							<tr>
								<td><strong>Last Name</strong> <span class="text-danger">*</span></td>
								<td class="p-2" width="80%"><input type="text" class="form-control" name="customer_lname" id="customer_lname" value="{{$customer->lastname}}"></td>
							</tr>
							<tr>
								<td><strong>E-mail Address</strong> <span class="text-danger">*</span></td>
								<td class="p-2"><input type="text" class="form-control" name="customer_email" id="customer_email" value="{{$customer->email}}"></td>
							</tr>
							<tr>
								<td><strong>Contact Number</strong> <span class="text-danger">*</span></td>
								<td class="p-2"><input type="text" class="form-control" name="customer_contact_number" id="customer_contact_number" value="{{$customer->mobile}}"></td>
							</tr>
							<tr>
								<td><strong>Barangay</strong> <span class="text-danger">*</span></td>
								<td class="p-2"><textarea id="customer_delivery_barangay" id="address_brgy" class="form-control" rows="3">{{$customer->address_street}}</textarea></td>
							</tr>
							<tr>
								<td><strong>City</strong> <span class="text-danger">*</span></td>
								<td class="p-2">
									<input type="text" class="form-control" id="customer_delivery_city" value="{{$customer->address_city}}">
								</td>
							</tr>
							<tr>
								<td><strong>Province</strong> <span class="text-danger">*</span></td>
								<td class="p-2">
									<input type="text" class="form-control" id="customer_delivery_province" value="{{$customer->address_province}}">
								</td>
							</tr>
							<tr>
								<td><strong>Zip Code</strong> <span class="text-danger">*</span></td>
								<td class="p-2"><input type="text" name="customer_delivery_zip" id="customer_delivery_zip" class="form-control" value="{{$customer->address_zip}}"></td>
							</tr>
							<tr>
								<td><strong>Notes</td>
								<td class="p-2">
									<textarea name="other_instruction" id="other_instruction" class="form-control" rows="3"></textarea>
								</td>
							</tr>
						</tbody>
					</table>

					<br>
					<a href="#" class="btn bg-color text-white tab-linker float-end" rel="2" onclick="update_details();">Next <i class="icon-arrow-circle-right"></i></a>
				</div>

				<div id="ptab2">
					<h2>Shipping Options</h2>
					
					<div class="row">
						<div class="col-md-12">
							<div class="row justify-content-center">
								<label for="shipping-option-d2d" class="col-sm-6 col-md-4">
									<div class="pricing-box text-center shadow-none border">
										<input type="radio" class="required mt-3" autocomplete="off" name="devlivery_type" id="shipping-option-d2d" value="d2d" onclick="shipping_type('d2d');" checked>
										<div class="pricing-price">
											<h3 class="nott ls0 mb-0">Door-to-Door</h3>
										</div>
										<div class="px-3">
											<p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										</div>
									</div>
								</label>

								<label for="shipping-option-pickup" class="col-sm-6 col-md-4">
									<div class="pricing-box text-center shadow-none border">
										<input type="radio" class="required mt-3" autocomplete="off" name="devlivery_type" id="shipping-option-pickup" value="pickup" onclick="shipping_type('pickup');">
										<div class="pricing-price">
											<h3 class="nott ls0 mb-0">For Pickup</h3>
										</div>
										<div class="px-3">
											<p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										</div>
									</div>
								</label>

								<input type="hidden" name="shippingOption" id="shippingOption" value="d2d">
							</div>
						</div>
						
						{{--<div class="col-md-4">
							<div id="row">
								<div class="input-group mb-3">
									<input type="text" class="form-control m-input" placeholder="Enter Coupon Code..">
								</div>
							</div>

							<div id="newinput"></div>
							<button id="rowAdder" type="button" class="btn btn-dark">
								<span class="icon icon-plus-square1"></span> Add Coupon
							</button>
						</div>--}}
					</div>
					
					<br>
					<a href="#" class="btn bg-color text-white tab-linker float-start" rel="1"><i class="icon-arrow-circle-left"></i> Previous</a>
					<a href="#" class="btn bg-color text-white tab-linker float-end" rel="3">Next <i class="icon-arrow-circle-right"></i></a>
				</div>

				<div id="ptab3">
					<h2>Payment Method</h2>
					
					<div class="row">
						<div class="col-md-12">
							<div class="row justify-content-center">
								<label for="payment-option-card" class="col-sm-6 col-md-4">
									<div class="pricing-box text-center shadow-none border">
										<input type="radio" class="required mt-3" autocomplete="off" id="payment-option-card" checked>
										<div class="pricing-price">
											<h3 class="nott ls0 mb-0">Credit / Debit Card</h3>
										</div>
										<div class="px-3">
											<p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										</div>
									</div>
								</label>
							</div>
						</div>
					</div>
					
					<br>
					<a href="#" class="btn bg-color text-white tab-linker float-start" rel="2"><i class="icon-arrow-circle-left"></i> Previous</a>
					<a href="#" class="btn bg-color text-white tab-linker float-end" rel="4">Next <i class="icon-arrow-circle-right"></i></a>
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
							  		<h3 class="m-0"><strong id="ck_billed_to"></strong></h3>
							  		<span id="ck_email"></span>
									<br><span id="ck_contact"></span>
									<br><span id="ck_address"></span>
									<br><span id="ck_zip"></span>
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
							@php $subtotal = 0; $totalqty = 0; $grandtotal = 0; @endphp
							@foreach($orders as $order)
								@php
									$subtotal += $order->price*$order->qty;
									$totalqty += $order->qty;
								@endphp
								<tr class="cart_item">
									<td class="cart-product-thumbnail">
										<a href="javascript:;"><img width="64" height="64" src="{{ asset('storage/products/'.$order->product->photoPrimary) }}" alt="{{$order->product->name}}"></a>
									</td>

									<td class="cart-product-name">
										<a href="#">{{ $order->product->name }}</a>
									</td>

									<td class="cart-product-price">
										<span class="amount">₱{{ number_format($order->price,2) }}</span>
									</td>

									<td class="cart-product-quantity">
										<span>{{$order->qty}}</span> pc(s).
									</td>

									<td class="cart-product-subtotal">
										<span class="amount">₱{{ number_format($order->price*$order->qty,2) }}</span>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<div class="row">
						<div class="col-md-6">
							<p class="text-danger">Notes</p>
							<p id="ck_notes"></p>
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
												<span class="amount">₱{{ number_format($subtotal,2) }}</span>
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
											<td class="cart-product-name">
												<strong>Total</strong>
											</td>

											<td class="cart-product-name text-end">
												<input type="hidden" name="total_amount" id="total_amount" value="{{$subtotal}}">
												<span class="amount color lead"><strong>₱{{ number_format($subtotal,2) }}</strong></span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>


					<input type="hidden" id="coupon_total_discount" name="coupon_total_discount" value="0">

					<br>
					<a href="#" class="btn bg-color text-white tab-linker float-start" rel="3"><i class="icon-arrow-circle-left"></i> Previous</a>
					<a href="javascript:;" class="btn bg-color text-white float-end" onclick="place_order();">Complete Order <i class="icon-check-circle"></i></a>
				</div>
			</form>
		</div>
	</div>	
</div>
@endsection

@section('pagejs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

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

	$(function() {

		$( "#processTabs" ).tabs({ show: { effect: "fade", duration: 400 } });
		$( ".tab-linker" ).click(function() {
			var nxt_tab = $(this).attr('rel');

			if(nxt_tab == 2){
				var fname = $('#customer_fname').val();
				var lname = $('#customer_lname').val();
				var email = $('#customer_email').val();
				var contact = $('#customer_contact_number').val();
				var brgy = $('#customer_delivery_barangay').val();
				var city = $('#customer_delivery_city').val();
				var province = $('#customer_delivery_province').val();
				var zipcode = $('#customer_delivery_zip').val();

				if(fname.length === 0 || lname.length === 0 || contact.length === 0 || IsEmail(email) == false || zipcode.length === 0 || brgy.length === 0 || city.length === 0 || province.length === 0){
                    swal('Oops...', 'Please check required input fields.', 'error');
		            return false;

                } else {
                    $( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
					return false;
                }
			} else if(nxt_tab == 3){

	   			var sfOption = $('#shippingOption').val();

	            $( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
				return false;

			} else {
				$( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
				return false;
			}	
		});
	});

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