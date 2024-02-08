@extends('theme.main')

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
							<form class="mb-0" action="{{ route('search-product') }}" method="GET" autocomplete="off">
								<div class="searchbar">
									<input type="text" name="search" class="form-control form-input form-search" placeholder="Search a book" aria-label="Search news" aria-describedby="button-addon1" autocomplete="off" />
									<button class="form-submit-search" type="submit">
										<i class="icon-line-search"></i>
									</button>
								</div>
							</form>
						</div>
					</div>
					
					@include('theme.layouts.components.product-categories')
				</div>
			</div>
		</div>
		<div class="col-lg-9">
			<div class="form-group d-flex">
				<label for="inputState" class="col-form-label me-2">Sort by</label>
				<div class="">
					<select id="inputState" class="form-select">
						<option selected>Choose...</option>
						<option>A to Z</option>
						<option>Z to A</option>
						<option>By date</option>
					</select>
				</div>
			</div>
			
			<div class="row">
				@forelse($products as $product)
				<div class="product col-md-4 col-sm-6 sf-dress bottommargin-sm">
					<div class="grid-inner">
						<div class="product-image">
							<a href="{{ route('product.details',$product->slug) }}"><img src="{{ asset('storage/products/'.$product->photoPrimary) }}" alt="{{$product->name}}"></a>
							<!-- <div class="sale-flash badge bg-secondary p-2">Out of Stock</div> -->
						</div>
						<div class="product-desc">
							<div class="product-title"><h3><a href="{{ route('product.details',$product->slug) }}">{{$product->name}}</a></h3></div>
							<div class="product-price"><ins>₱{{number_format($product->price,2)}}</ins></div>
							<!-- <div class="product-price"><del>$24.99</del> <ins>$12.49</ins></div> -->
							<div class="product-rating">
								<i class="icon-star3"></i>
								<i class="icon-star3"></i>
								<i class="icon-star3"></i>
								<i class="icon-star3"></i>
								<i class="icon-star-half-full"></i>
							</div>
						</div>
					</div>
				</div>
				@empty
					<div class="alert alert-info">
                        No books found.
                    </div>
				@endforelse
			</div>
			
			{{ $products->links('theme.layouts.pagination') }}
		</div>
	</div>
</div>
@endsection