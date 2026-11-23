@extends('admin.layouts.app')

@section('pagetitle') Create Genre @endsection

@section('content')
<div class="container pd-x-0">
    <h4 class="mb-4">Create Product Genre</h4>
    <form action="{{ route('product-genres.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Genre Name *</label>
            <input name="name" value="{{ old('name') }}" required class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" name="status" value="1" class="custom-control-input" id="status" checked>
            <label class="custom-control-label" for="status">Published</label>
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('product-genres.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
