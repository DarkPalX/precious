@extends('theme.main')

@section('content')
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
			<h2>Manage Account</h2>

			@if (Session::has('success'))
			<div class="style-msg successmsg">
				<div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Well done!</strong> {{ Session::get('success') }}</div>
			</div>
			@endif

			<form method="post" action="{{ route('my-account.update-personal-info') }}">
			@csrf
				<div class="row">
					<div class="col-12">
						<div class="fancy-title title-border-color title-left">
							<h4>Personal Information</h4>
						</div>
					</div>
					
					<div class="col-md-6 form-group">
						<label>First Name:</label>
						<input type="text" name="firstname" id="" class="form-control required" value="{{$member->firstname}}" placeholder="">
					</div>
					
					<div class="col-md-6 form-group">
						<label>Last Name:</label>
						<input type="text" name="lastname" id="" class="form-control required" value="{{$member->lastname}}" placeholder="">
					</div>
					
					<div class="col-md-6 form-group">
						<label>Birth Date:</label>
						<input type="date" name="" id="" class="form-control required" value="{{date('Y-m-d') }}" placeholder="">
					</div>
					
					<div class="col-md-6 form-group">
						<label>Email Address:</label>
						<input type="text" name="email" id="" class="form-control required" value="{{$member->email}}" placeholder="">
					</div>
					
					<div class="col-12">
						<div class="fancy-title title-border-color title-left mt-4">
							<h4>Address Information</h4>
						</div>
					</div>
					
					<div class="col-md-6 form-group">
						<label>Street:</label>
						<input type="text" name="address_street" id="" class="form-control required" value="{{$member->address_street}}" placeholder="">
					</div>
					
					<div class="col-md-6 form-group">
						<label>Municipality:</label>
						<input type="text" name="address_municipality" id="" class="form-control required" value="{{$member->address_municipality}}" placeholder="">
					</div>
					
					<div class="col-md-6 form-group">
						<label>City:</label>
						<input type="text" name="address_city" id="" class="form-control required" value="{{$member->address_city}}" placeholder="">
					</div>
					
					<div class="col-md-6 form-group">
						<label>Region:</label>
						<input type="text" name="address_province" id="" class="form-control required" value="{{$member->address_province}}" placeholder="">
					</div>

					<div class="col-md-6 form-group">
						<label>Zip Code:</label>
						<input type="text" name="address_zip" id="" class="form-control required" value="{{$member->address_zip}}" placeholder="">
					</div>
					
					<div class="col-12">
						<div class="fancy-title title-border-color title-left mt-4">
							<h4>Contact Information</h4>
						</div>
					</div>
					
					<div class="col-md-6 form-group">
						<label>Contact Person:</label>
						<input type="text" name="" id="" class="form-control required" value="" placeholder="">
					</div>
					
					<div class="col-md-6 form-group">
						<label>Organization:</label>
						<input type="text" name="" id="" class="form-control required" value="" placeholder="">
					</div>
					
					<div class="col-md-4 form-group">
						<label>Telephone Number:</label>
						<input type="number" name="phone" id="" class="form-control required" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);" value="{{$member->phone}}" placeholder="">
					</div>
					
					<div class="col-md-4 form-group">
						<label>Mobile Number:</label>
						<input type="number" name="mobile" class="form-control required" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);" value="{{$member->mobile}}">
						
					</div>
					
					<div class="col-md-4 form-group">
						<label>Fax Number:</label>
						<input type="number" name="" id="" class="form-control required" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);" value="" placeholder="">
					</div>
					
				</div>

				<button type="submit" class="button button-border button-rounded ms-0 topmargin-sm button-smal">Save Changes</button>
				<a href="{{ route('customer.manage-account') }}" class="button button-3d button-black m-0 add_button">Reset</a>
			</form>
		</div>
	</div>
</div>
@endsection

