<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Ecommerce\Deliverablecities;
use App\Helpers\ListingHelper;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliverablecitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        Permission::module_init($this, 'delivery_rate');
    }

    public function index()
    {
        $searchFields = ['city', 'province', 'item_type', 'barangay'];

        $listing = new ListingHelper();

        $address = $listing->simple_search(Deliverablecities::class, $searchFields);

        // Simple search init data
        $filter = $listing->get_filter($searchFields);

        $searchType = 'simple_search';

        return view('admin.ecommerce.deliverablelocations.index', compact('address', 'filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ecommerce.deliverablelocations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'nullable',
            'rate' => 'required|numeric',
            'area' => 'nullable',
            'barangay' => 'nullable',
            'province' => 'required',
            'city' => 'required',
            // 'item_type' => 'required'
        ]);

        Deliverablecities::create([
            'rate' => $request->rate,
            'item_type' => $request->item_type,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'outside_manila' => ($request->has('outside_manila') ? '1' : '0'),
            'user_id' => Auth::id()
        ]);

        return back()->with('success','Successfully saved new location!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deliverablecities  $deliverablecities
     * @return \Illuminate\Http\Response
     */
    public function show(Deliverablecities $deliverablecities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deliverablecities  $deliverablecities
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rate = Deliverablecities::findOrFail($id);
        return view('admin.ecommerce.deliverablelocations.edit',compact('rate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deliverablecities  $deliverablecities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'nullable',
            'rate' => 'required|numeric',
            'area' => 'nullable',
            'barangay' => 'nullable',
            'province' => 'required',
            'city' => 'required',
            // 'item_type' => 'required'
        ]);

        Deliverablecities::findOrFail($id)->update([
            'rate' => $request->rate,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'item_type' => $request->item_type,
            'outside_manila' => ($request->has('outside_manila') ? '1' : '0'),
            'user_id' => Auth::id()
        ]);
        
//        $address = Deliverablecities::all();
//        return view('admin.ecommerce.deliverablelocations.index',compact('address'))->with('success','Successfully updated delivery rate!');

        return redirect()->route('locations.index')->with('success','Successfully updated delivery rate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deliverablecities  $deliverablecities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deliverablecities $deliverablecities)
    {
        //dd($deliverablecities);
    }

    public function delete(Request $request)
    {
        Deliverablecities::whereId($request->add_id)->delete();
        return back()->with('success','Successfully deleted location');
    }
}
