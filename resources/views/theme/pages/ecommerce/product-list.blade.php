@extends('theme.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div class="container topmargin-lg bottommargin-lg">
	<div class="row">
		<span onclick="closeNav()" class="dark-curtain"></span>
		<div class="col-lg-12 col-md-5 col-sm-12">
			<span onclick="openNav()" class="button button-small button-circle border-bottom ms-0 text-initial nols fw-normal noleftmargin d-lg-none mb-4"><span class="icon-chevron-left me-2 color-2"></span> Category</span>
		</div>
		<div class="col-lg-3 pe-lg-4">
			<div class="tablet-view">
				<a href="javascript:void(0)" class="closebtn d-block d-lg-none" onclick="closeNav()">&times;</a>

				<div class="card border-0">
					<div class="border-0 mb-5">
						<h3 class="mb-3">Search</h3>
						<div class="search">
							<form class="mb-0" action="{{ route( Str::contains(url()->current(), 'ebook') ? 'search-product-ebook' : 'search-product') }}" method="get">
							{{-- <form action="{{ route('search-product') }}" method="GET"> --}}
                                <div class="searchbar">
                                    <input type="text" name="keyword" id="keyword" class="form-control form-input form-search" placeholder="Search a book" aria-label="Search a book" aria-describedby="button-addon1" value="@if(request()->has('keyword')) {{ request('keyword') }} @endif"/>
                                    <button class="form-submit-search" type="submit">
                                        <i class="icon-line-search"></i>
                                    </button>
                                </div>
								{{-- hidden --}}
								<input type="text" name="sort_by" value="@if(request()->has('sort_by')){{ request('sort_by') }}@endif" hidden/>
                            </form>
						</div>
					</div>
					
					@include('theme.layouts.components.product-categories')

				</div>
			</div>
		</div>
		<div class="col-lg-9">
			<form id="sortForm" action="{{ route( Str::contains(url()->current(), 'ebook') ? 'search-product-ebook' : 'search-product') }}" method="GET">
				<div class="form-group d-flex">
					<label for="sort_by" class="col-form-label me-2">Sort by</label>
					<div class="">
						<select id="sort_by" class="form-select" name="sort_by" onchange="document.getElementById('sortForm').submit()">
							<option value="">Choose...</option>
							<option value="name_asc" {{ request('sort_by')== "name_asc"? 'selected' : '' }}>A to Z</option>
							<option value="name_desc" {{ request('sort_by')== "name_desc"? 'selected' : '' }}>Z to A</option>
							<option value="price_asc" {{ request('sort_by')== "price_asc"? 'selected' : '' }}>Prices Low - High</option>
							<option value="price_desc" {{ request('sort_by')== "price_desc"? 'selected' : '' }}>Prices High - Low</option>
							<option value="date_desc" {{ request('sort_by')== "date_desc"? 'selected' : '' }}>Recent - Old</option>
							<option value="date_asc" {{ request('sort_by')== "date_asc"? 'selected' : '' }}>Old - Recent</option>
						</select>
					</div>
				</div>
				{{-- hidden --}}
				<input type="text" name="keyword" value="@if(request()->has('keyword')){{ request('keyword') }}@endif" hidden/>
			</form>
			
			@if(request()->has('keyword') && request('keyword') != '')
				@if(count($products) > 0)
					<div class="style-msg successmsg">
						<div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Woo hoo!</strong> We found <strong>(<span>{{ count($products) }}</span>)</strong> matching results.</div>
					</div>
				@else
					<div class="style-msg2 errormsg">
						<div class="msgtitle p-0 border-0">
							<div class="sb-msg">
								<i class="icon-thumbs-up"></i><strong>Uh oh</strong>! <span><strong>{{ app('request')->input('keyword') }}</strong></span> you say? Sorry, no results!
							</div>
						</div>
						<div class="sb-msg">
							<ul>
								<li>Check the spelling of your keywords.</li>
								<li>Try using fewer, different or more general keywords.</li>
							</ul>
						</div>
					</div>
				@endif
			@endif
			
			<div class="row">
				@forelse($products as $product)
					<div class="product col-4 col-md-3 col-sm-6 sf-dress bottommargin-sm">
						<div class="grid-inner">
							<div class="product-image">
								<a href="{{ route('product.details',$product->slug) }}"><img src="{{ asset('storage/products/'.$product->photoPrimary) }}" onerror="this.onerror=null;this.src='{{ asset('storage/products/no-image.jpg') }}';" alt="{{$product->name}}"></a>
								@if( $product->inventory <= 0 && (strtolower($product->book_type) != "ebook" && strtolower($product->book_type) != "e-book") )
									<div class="sale-flash badge bg-danger p-2">Out of Stock</div>
								@endif
								@if(strtolower($product->book_type) == "ebook" || strtolower($product->book_type) == "e-book")
									<div class="sale-flash badge bg-info p-2">E-book</div>
								@endif
							
								{{-- Add to Cart button at bottom left with margin --}}
								
                                {{-- <div class="bg-overlay-content align-items-end justify-content-start flex-column">
                                    <a data-bs-toggle="tooltip" data-bs-placement="left" onclick="" title="Add to Bag" data-hover-animate="fadeInRightSmall" href="javascript:void(0)" class="btn btn-light h-bg-color h-text-light border-0 mb-2"><i class="icon-shopping-bag"></i></a>
                                </div> --}}

								<div class="position-relative">
									@if(strtolower($product->book_type) == "ebook" || strtolower($product->book_type) == "e-book")
										@if(App\Models\CustomerLibrary::already_purchased($product->id))
											@if(App\Models\Ecommerce\Cart::is_product_on_cart($product->id))
												<a href="javascript:void(0)" class="btn btn-success d-flex align-items-center justify-content-center position-absolute" style="width: 40px; height: 40px; bottom: 10px; right: 10px; z-index: 10;" title="Add to Bag">
													<i class="icon-check"></i>
												</a>
											@else
											
												{{-- HIDDEN BUT SHOWN IF ADDED TO CART --}}
												<a id="added_to_cart_btn{{ $product->id }}" href="javascript:void(0)" class="btn btn-success d-flex align-items-center justify-content-center position-absolute" style="width: 40px; height: 40px; bottom: 10px; right: 10px; z-index: 10; display: none !important;" title="Added to Bag">
													<i class="icon-check"></i>
												</a>

												{{-- ADD TO CART BUTTON --}}
												<a id="add_to_cart_btn{{ $product->id }}" href="javascript:void(0)" onclick="add_to_cart('{{$product->id}}', '{{$product->ebook_discount_price > 0 ? $product->ebook_discount_price : $product->ebook_price}}', '{{$product->inventory}}', '{{$product->name}}', '{{$product->photoPrimary}}', '{{$product->book_type}}');" class="btn btn-secondary d-flex align-items-center justify-content-center position-absolute" style="width: 40px; height: 40px; bottom: 10px; right: 10px; z-index: 10;" title="Add to Bag">
													<i class="icon-shopping-bag"></i>
												</a>
											@endif
										@else
											<a href="javascript:void(0)" class="btn btn-transparent text-success d-flex align-items-center justify-content-center position-absolute" style="bottom: 10px; right: 0px; z-index: 10;" title="Owned">
												OWNED
											</a>
										@endif
									@else
										@if( !($product->inventory <= 0 && (strtolower($product->book_type) != "ebook" && strtolower($product->book_type) != "e-book")) )
											<a href="javascript:void(0)" onclick="add_to_cart('{{$product->id}}', '{{$product->discount_price > 0 ? $product->discount_price : $product->price}}', '{{$product->inventory}}', '{{$product->name}}', '{{$product->photoPrimary}}', '{{$product->book_type}}');" class="btn btn-secondary d-flex align-items-center justify-content-center position-absolute" style="width: 40px; height: 40px; bottom: 10px; right: 10px; z-index: 10;" title="Add to Bag">
												<i class="icon-shopping-bag"></i>
											</a>
										@endif
									@endif
								</div>
								
							</div>

							@if(strtolower($product->book_type) == "ebook" || strtolower($product->book_type) == "e-book")
								<div class="product-desc">
									<div class="product-title"><span style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;"><a href="{{ route('product.details',$product->slug) }}">{{$product->name}}</a></span></div>
									{!! ($product->ebook_discount_price > 0 || $product->ebookdiscountedprice != $product->ebook_price ? '<div class="product-price"><del class="text-danger">' . number_format($product->ebook_price, 2) . '</del> <ins>' . number_format($product->ebookdiscountedprice != $product->ebook_price ? $product->ebookdiscountedprice : $product->ebook_discount_price, 2) . '</ins></div>' : '<div class="product-price"><ins>' . number_format($product->ebook_price, 2) . '</ins></div>') !!}
									<div class="product-rating text-warning">
										@for($star = 1; $star <= 5; $star++)
											<i class="icon-star{{ $star <= $product->rating ? '3' : '-empty' }}"></i>
										@endfor
									</div>
								</div>
							@else
								<div class="product-desc">
									<div class="product-title"><span style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;"><a href="{{ route('product.details',$product->slug) }}">{{$product->name}}</a></span></div>
									{!! ($product->discount_price > 0 || $product->discountedprice != $product->price ? '<div class="product-price"><del class="text-danger">' . number_format($product->price, 2) . '</del> <ins>' . number_format($product->discountedprice != $product->price ? $product->discountedprice : $product->discount_price, 2) . '</ins></div>' : '<div class="product-price"><ins>' . number_format($product->price, 2) . '</ins></div>') !!}
									<div class="product-rating text-warning">
										@for($star = 1; $star <= 5; $star++)
											<i class="icon-star{{ $star <= $product->rating ? '3' : '-empty' }}"></i>
										@endfor
									</div>
								</div>
							@endif

						</div>
					</div>
				@empty
					{{-- <div class="alert alert-info">
                        No books found.
                    </div> --}}
				@endforelse
			</div>
			
			{{ $products->links('theme.layouts.pagination') }}
		</div>
	</div>
</div>
@endsection

@section('pagejs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>

        function buynow(){
            var qty = $('#quantity').val();
            $('#buy_now_qty').val(qty);

            $('#buy-now-form').submit();
        }

        
        function add_to_cart(product, price, remaining_stock, name, image, book_type){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var qty   = 1;
            // var price = parseFloat($('#product_price').val());
            // var remaining_stock = parseFloat($('#remaining_stock').val());

            if(qty <= remaining_stock || (book_type.toLowerCase() === "e-book" || book_type.toLowerCase() === "ebook")){

                $.ajax({
                    data: {
                        "product_id": product, 
                        "qty": qty,
                        "price": price,
                        "_token": "{{ csrf_token() }}",
                    },
                    type: "post",
                    url: "{{route('product.add-to-cart')}}",
                    success: function(returnData) {
                        $("#loading-overlay").hide();
                        if (returnData['success']) {

                            $('.top-cart-number').html(returnData['totalItems']);


                            var cartotal = parseFloat($('#input-top-cart-total').val());
                            var productotal = price*qty;
                            var newtotal = cartotal+productotal;


                            $('#top-cart-total').html('₱'+newtotal.toFixed(2));
                            $('#input-top-cart-total').val(newtotal);

                            var cartItem = $('#top-cart-items').find('[data-product-id="' + product + '"]');
                            if (cartItem.length) {
                                // If the item already exists in the cart, update its quantity and price
                                var oldQty = parseFloat(cartItem.find('.top-cart-item-quantity').text().trim().replace('x ', ''));
                                var newQty = oldQty + qty;
                                var oldPrice = parseFloat(cartItem.find('.top-cart-item-price').text().trim().replace('₱', ''));
                                var productTotal = price * qty;
                                var newTotal = oldPrice + productTotal;

                                cartItem.find('.top-cart-item-quantity').text('x ' + newQty);
                                // cartItem.find('.top-cart-item-price').text('₱' + newTotal.toFixed(2));
                            } else {

                                $('#top-cart-items').append(
                                    '<div class="top-cart-item" data-product-id="' + product + '">' +
                                    '<div class="top-cart-item-image border-0">' +
                                    '<a href="#"><img src="{{ asset('storage/products/') }}/' + image + '" alt="Cart Image 1" /></a>' +
                                    '</div>' +
                                    '<div class="top-cart-item-desc">' +
                                    '<div class="top-cart-item-desc-title">' +
                                    '<a href="#" class="fw-medium">' + name + '</a>' +
                                    '<span class="top-cart-item-price d-block">₱' + price + '</span>' +
                                    '<div class="d-flex mt-2">' +
                                    '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>Reload to Edit</u></a>' +
                                    '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product(' + returnData['cartId'] + ');"><u>Remove</u></a>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="top-cart-item-quantity">x ' + qty + '</div>' +
                                    '</div>' +
                                    '</div>'
                                );
                            }

                            $.notify("Product Added to your cart",{ 
                                position:"bottom right", 
                                className: "success" 
                            });

                            if(book_type.toLowerCase() === "e-book" || book_type.toLowerCase() === "ebook"){
                                $('#add_to_cart_btn' + product).removeClass('d-flex').hide();
                                $('#added_to_cart_btn' + product).show();
                            }
							

                        } else {
                            swal({
                                toast: true,
                                position: 'center',
                                title: "Warning!",
                                text: "We have insufficient inventory for this item.",
                                type: "warning",
                                showCancelButton: true,
                                timerProgressBar: true, 
                                closeOnCancel: false

                            });
                        }
                    }
                });

                $('#quantity').val(1);
                $('#remaining_stock').val(remaining_stock - qty);
            }
            else{
                swal({
                    toast: true,
                    position: 'center',
                    title: "Warning!",
                    text: "We have insufficient inventory for this item.",
                    type: "warning",
                    showCancelButton: true,
                    timerProgressBar: true, 
                    closeOnCancel: false

                });
            }
        }
        
    </script>

    <script>
        
        // for edit quantity
        function FormatAmount(number, numberOfDigits) {
            var amount = parseFloat(number).toFixed(numberOfDigits);
            var num_parts = amount.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            return num_parts.join(".");
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

        function plus_qty(id){
            var qty = parseFloat($('#quantity'+id).val())+1;

            if(parseInt($('#maxorder'+id).val()) < 1){
                swal({
                    title: '',
                    text: 'Sorry. Currently, there is no sufficient stocks for the item you wish to order.',
                    icon: 'warning'
                });

                $('#quantity'+id).val($('#prevqty'+id).val()-1);
                return false;
            }

            order_qty(id,qty);
        }

        function minus_qty(id){
            var qty = parseFloat($('#quantity'+id).val())-1;
            order_qty(id,qty);
        }

        function order_qty(id,qty){

            if(qty == 0){
                $('#quantity'+id).val(1).val();
                return false;
            }
            
            var price = $('#cartItemPrice'+id).val();
            total_price  = parseFloat(price)*parseFloat(qty);

            $('#order'+id+'_total_price').html('₱'+FormatAmount(total_price,2));
            $('#input_order'+id+'_product_total_price').val(total_price);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                data: { 
                    "quantity": qty, 
                    "orderID": id, 
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('cart.update')}}",
                
                success: function(returnData) {

                    $('#maxorder'+id).val(returnData.maxOrder);
                    $('.top-cart-number').html(returnData['totalItems']);
                    $('#prevqty'+id).val(qty);
                    // var promo_discount = parseFloat(returnData.total_promo_discount);

                    // let subtotal = 0;
                    // $(".input_product_total_price").each(function() {
                    //     if(!isNaN(this.value) && this.value.length!=0) {
                    //         subtotal += parseFloat(this.value);
                    //     }
                    // });

                    // $('#subtotal').val(subtotal);


                    // for the sidebar cart total
                    // var cartotal = parseFloat($('#input-top-cart-total').val());
                    // var productotal = price*qty;
                    // var newtotal = cartotal+total_price;
                    
                    // alert(cartotal);

                    // $('#input-top-cart-total').val(newtotal);
                    // $('#top-cart-total').html('₱'+newtotal.toFixed(2));
                    // 
                    
                    // resetCoupons();
                    cart_total();
                }
            });
        }

        function cart_total(){
            var couponTotalDiscount = parseFloat($('#coupon_total_discount').val());
            var promoTotalDiscount = 0;
            var subtotal = 0;

            $(".input_product_total_price").each(function() {
                if(!isNaN(this.value) && this.value.length!=0) {
                    subtotal += parseFloat(this.value);
                }
            });

            if(couponTotalDiscount == 0){
                $('#couponDiscountDiv').css('display','none');
            }

            // var totalDeduction = promoTotalDiscount + couponTotalDiscount;
            // var grandtotal = subtotal - totalDeduction;
            
            // $('#subtotal').html('₱'+FormatAmount(subtotal,2));

            $('#top-cart-total').val(subtotal);
            $('#top-cart-total').html('₱'+subtotal.toFixed(2));
        }
    </script>
@endsection