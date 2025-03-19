@extends('theme.main')

@section('content')
@php
    $modals='';
@endphp

<div class="container topmargin-lg bottommargin-lg">
    <div class="row">
        <span onclick="closeNav()" class="dark-curtain"></span>
        <div class="col-lg-12 col-md-5 col-sm-12">
            <span onclick="openNav()" class="button button-small button-circle border-bottom ms-0 text-initial nols fw-normal noleftmargin d-lg-none mb-4"><span class="icon-chevron-left me-2 color-2"></span> Quicklinks</span>
        </div>
        <div class="col-lg-3 pe-lg-4">
            @include('theme.pages.customer.sidebar')
        </div>

        <div class="col-lg-9">
            <h2>Subscription Plan</h2>
			
			<div class="container">
				<div class="row">
					<div class="col-12">
						<table class="table cart mb-5">
							<thead>
								<tr>
									<th class="cart-product-name">Plan</th>
									<th class="cart-product-price">Price</th>
									<th class="cart-product-quantity">Quantity</th>
									<th class="cart-product-subtotal">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr class="cart_item">

									<td class="cart-product-name">
										<a href="#" title="{{ $subscription->short_description }}">{{ $subscription->title }}</a><br>
									</td>

									<td class="cart-product-price">
										<span class="amount">{{ $subscription->price }}</span>
									</td>

									<td class="cart-product-quantity">
										<div class="quantity">
                                            1x
										</div>
									</td>

									<td class="cart-product-subtotal">
										<span class="amount">{{ $subscription->price }}</span>
									</td>
								</tr>
							</tbody>

						</table>
					</div>
					
					<div class="col-md-6">
                        &nbsp;
					</div>
					
					<div class="col-md-6">
						<h4>Totals</h4>

						<div class="table-responsive">
                            
                            <form action="{{ route('customer.subscription-checkout') }}" method="post">
                                @csrf

                                <table class="table cart cart-totals">
                                    <tbody>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Subtotal</strong>
                                            </td>

                                            <td class="cart-product-name text-end">
                                                <span class="amount">{{ $subscription->price }}</span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Payment Method</strong>
                                            </td>

                                            <td class="cart-product-name text-end align-top">
                                                <select id="mode_payment" name="mode_payment" class="form-control text-primary text-end bg-transparent border-0 p-0" required>
                                                    <option value="" disabled selected>Select Method</option>
                                                    <option value="EWallet" @if(auth()->user()->ecredits < $subscription->price) disabled @endif>E-Wallet</option>
                                                    {{-- <option value="PayPal">Paypal</option> --}}
                                                </select>
                                            </td>
                                        </tr>
                                        {{-- <tr><a href="{{ route('paypal.create') }}" class="btn btn-primary">Pay with PayPal</a></tr> --}}
                                        <tr id="ewalletrow" class="cart_item">
                                            <td class="cart-product-name">
                                                <small>E-Wallet Balance</small>
                                            </td>

                                            <td class="cart-product-name text-end">
                                                <small>{{ auth()->user()->ecredits }}</small>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Total</strong>
                                            </td>

                                            <td class="cart-product-name text-end">
                                                <span class="amount color lead"><strong>{{ $subscription->price }}</strong></span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">

                                            {{-- FOR POST DATA --}}
                                            <td class="cart-product-name">
                                                <input name="plan_id" value="{{ $subscription->id }}" hidden/>
                                                <input name="title" value="{{ $subscription->title }}" hidden/>
                                                <input name="no_days" value="{{ $subscription->no_days }}" hidden/>
                                                <input name="amount_paid" value="{{ $subscription->price }}" hidden/>
                                            </td>

                                            <td class="text-end">											
                                                <button class="btn btn-dark">
                                                    Subscribe Now
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </form>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>
</div>

@endsection

@section('pagejs')
	<script>
        $(document).ready(function () {
            $("#ewalletrow").hide();
            
            $("#mode_payment").on("change", function () {
                if ($(this).val() === "EWallet") {
                    $("#ewalletrow").show();
                } else {
                    $("#ewalletrow").hide();
                }
            });
        });

	</script>
@endsection

