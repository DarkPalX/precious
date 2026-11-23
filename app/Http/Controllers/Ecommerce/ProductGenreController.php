<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\ProductGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProductGenreController extends Controller
{
    public function index()
    {
        $genres = ProductGenre::orderBy('name')->paginate(20);
        return view('admin.ecommerce.product-genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.ecommerce.product-genres.create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:product_genres,name',
        ])->validate();

        ProductGenre::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->has('status') ? 'PUBLISHED' : 'PRIVATE',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('product-genres.index')->with('success', 'Genre created successfully.');
    }

    public function edit($id)
    {
        $genre = ProductGenre::findOrFail($id);
        return view('admin.ecommerce.product-genres.edit', compact('genre'));
    }

    public function update(Request $request, $id)
    {
        $genre = ProductGenre::findOrFail($id);

        Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:product_genres,name,'.$genre->id,
        ])->validate();

        $genre->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->has('status') ? 'PUBLISHED' : 'PRIVATE',
        ]);

        return redirect()->route('product-genres.index')->with('success', 'Genre updated successfully.');
    }

    public function destroy($id)
    {
        ProductGenre::findOrFail($id)->delete();
        return back()->with('success', 'Genre deleted successfully.');
    }
}
