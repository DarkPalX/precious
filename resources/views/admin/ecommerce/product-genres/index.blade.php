@extends('admin.layouts.app')

@section('pagetitle') Manage Genres @endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">CMS</a></li>
                <li class="breadcrumb-item active">Product Genres</li>
            </ol>
            <h4>Manage Product Genres</h4>
        </div>
        <a href="{{ route('product-genres.create') }}" class="btn btn-primary btn-sm">Create Genre</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead><tr><th>Genre</th><th>Slug</th><th>Status</th><th style="width:120px">Options</th></tr></thead>
            <tbody>
            @forelse($genres as $genre)
                <tr>
                    <td>{{ $genre->name }}</td>
                    <td>{{ $genre->slug }}</td>
                    <td>{{ $genre->status }}</td>
                    <td class="text-right">
                        <nav class="nav table-options">
                            <a class="nav-link" href="{{ route('product-genres.edit', $genre->id) }}" title="Edit Genre"><i data-feather="edit"></i></a>
                            <a class="nav-link" href="#" title="Delete Genre" onclick="event.preventDefault(); if (confirm('Delete this genre?')) { document.getElementById('delete-genre-{{ $genre->id }}').submit(); }"><i data-feather="trash"></i></a>
                            <form id="delete-genre-{{ $genre->id }}" action="{{ route('product-genres.destroy', $genre->id) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </nav>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-danger">No genres found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $genres->links() }}
</div>
@endsection
