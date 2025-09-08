@extends('admin.layouts.app')

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('locations.index')}}">Deliverable Locations</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create new rate</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create new rate</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form id="delivery_form" autocomplete="off" action="{{ route('locations.store') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="form-group" id="region_div">
                        <label class="d-block">Province *</label>
                        <input type="text" class="form-control" name="province" placeholder="" value="{{ old('province') }}">    
                        @if ($errors->has('province'))
                            <span class="text-danger">{{ $errors->first('province') }}</span>
                        @endif                                   
                    </div>
                    <div class="form-group" id="region_div">
                        <label class="d-block">City/Municipality *</label>
                        <input type="text" class="form-control" name="city" placeholder="" value="{{ old('city') }}">    
                        @if ($errors->has('city'))
                            <span class="text-danger">{{ $errors->first('city') }}</span>
                        @endif                                   
                    </div>
                    {{-- <div class="form-group" id="region_div">
                        <label class="d-block">Barangay</label>
                        <input type="text" class="form-control" name="barangay" placeholder="Barangay" value="{{old('barangay')}}">
                        @if ($errors->has('barangay'))
                            <span class="text-danger">{{ $errors->first('barangay') }}</span>
                        @endif
                    </div> --}}
                    <div class="form-group" id="region_div">
                        <label class="d-block">Rate *</label>
                        <input type="number" class="form-control" name="rate" min="1" step="0.01" value="{{old('rate',0.00)}}">     
                        @if ($errors->has('rate'))
                            <span class="text-danger">{{ $errors->first('rate') }}</span>
                        @endif                                  
                    </div> 
                    {{-- <div class="form-group" id="region_div">
                        <label class="d-block">Item Type *</label>
                        <select name="item_type" id="item_type" class="form-control" required="required">

                            <option value=""> - Select - </option>
                            <option value="misc">Miscellaneous</option>
                            <option value="lechon">Lechon</option>
                        </select>                             
                        @if ($errors->has('item_type'))
                            <span class="text-danger">{{ $errors->first('item_type') }}</span>
                        @endif      
                    </div>    --}}
                    <div class="form-group">
                        <label class="d-block">Outside or Within Manila</label>
                        <div class="custom-control custom-switch @error('status') is-invalid @enderror">
                            <input type="checkbox" class="custom-control-input" name="outside_manila" id="customSwitch1">
                            <label class="custom-control-label" id="label_visibility" for="customSwitch1">Within Manila</label>                           
                        </div>                             
                    </div>                     
                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Submit</button>
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
            $('#label_visibility').html('Outside Manila');
        }
        else{
            $('#label_visibility').html('Within Manila');
        }
    });
  </script>
@endsection

