@extends('admin.layouts.app')

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('locations.index')}}">Serviceable Areas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Delivery Rate</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Update Delivery Rate</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form id="delivery_form" autocomplete="off" action="{{ route('locations.update',$rate->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    {{-- <div class="form-group">
                        <label class="d-block">Location *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{$rate->name}}" maxlength="150">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                                      
                    </div> --}}

                    <div class="form-group">
                        <label class="d-block">Province *</label>
                        <input type="text" class="form-control @error('province') is-invalid @enderror" name="province" id="province" maxlength="150" value="{{ $rate->province }}" required>
                        @error('province')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                                       
                    </div>
                    <div class="form-group">
                        <label class="d-block">City *</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" maxlength="150" value="{{ $rate->city }}">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                                       
                    </div>
                    <div class="form-group">
                        <label class="d-block">Barangay *</label>
                        <input type="text" class="form-control @error('barangay') is-invalid @enderror" name="barangay" id="barangay" maxlength="150" value="{{ $rate->barangay }}">
                        @error('barangay')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                                       
                    </div>
                    <div class="form-group">
                        <label class="d-block">Rate *</label>
                        <input type="number" class="form-control @error('rate') is-invalid @enderror text-right" name="rate" id="rate" min="1" step="0.01" onclick="select()" value="{{$rate->rate}}">
                        @error('rate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror                                     
                    </div>   

                    <div class="form-group">
                        <label class="d-block">Visibility</label>
                        <div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                            <input type="checkbox" class="custom-control-input" name="visibility" {{ ($rate->status == 'PUBLISHED' ? "checked":"") }} id="customSwitch1">
                            <label class="custom-control-label" id="label_visibility" for="customSwitch1">{{ucwords(strtolower($rate->status))}}</label>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Update</button>
                    <a class="btn btn-outline-secondary btn-sm btn-uppercase" href="{{ route('locations.index') }}">Cancel</a>
            </form>
            </div>
        </div>
    </div>
</div>
<div id="aaa"></div>
@endsection

@section('pagejs')
    <script>
        $("#customSwitch1").change(function() {
            if(this.checked) {
                $('#label_visibility').html('Published');
            }
            else{
                $('#label_visibility').html('Private');
            }
        });
    </script>
@endsection

