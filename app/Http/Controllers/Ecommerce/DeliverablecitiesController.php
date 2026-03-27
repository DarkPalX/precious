<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Ecommerce\Deliverablecities;
use App\Helpers\ListingHelper;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ecommerce\{FormAttribute};

use Response;


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
        $searchFields = ['province', 'city', 'municipality'];

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

    public function download_template()
    {
        $attributes = FormAttribute::orderBy('name', 'asc')->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=location-rates.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $deliverable_cities = DeliverableCities::all();

        $columns = ['Province', 'Name', 'City', 'Municipality', 'Outside Manila', 'Rate'];

        foreach ($attributes as $attr) {
            $columns[] = $attr->name;
        }

        $callback = function() use ($deliverable_cities, $columns, $attributes)
        {
            $file = fopen('php://output', 'w');

            // ✅ Fix encoding for Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($file, $columns);

            foreach ($deliverable_cities as $row) {

                $name = $row->city ?: $row->municipality;

                $data = [
                    $row->province,
                    $name,
                    $row->city,
                    $row->municipality,
                    $row->outside_manila,
                    $row->rate
                ];

                foreach ($attributes as $attr) {
                    $data[] = $row->{$attr->name} ?? '';
                }

                fputcsv($file, $data);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function upload_template(Request $request)
    {
        if (!$request->hasFile('csv')) {
            return back()->with('error', 'No file uploaded.');
        }

        $file = $request->file('csv');
        $path = $file->getRealPath();

        // 1. Detect and fix encoding before processing
        $content = file_get_contents($path);
        
        // Check if it's already UTF-8; if not, convert from Windows-1252 (Standard Excel CSV)
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
        }

        // Use a temporary stream to process the converted content
        $handle = fopen('php://temp', 'r+');
        fwrite($handle, $content);
        rewind($handle);

        set_time_limit(0);
        $row = 0;

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $row++;

            if ($row == 1 || !$data || count(array_filter($data)) == 0) continue;

            // 2. Clean and Normalize Data
            $data = array_map(function ($value) {
                // Remove weird hidden characters (like BOM) and trim
                $clean = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $value);
                return trim($clean);
            }, $data);

            // Map columns based on your image structure
            $province     = $data[0] ?? null;
            $name         = $data[1] ?? null; // e.g. "Las Piñas"
            $city         = $data[2] ?? null;
            $municipality = $data[3] ?? null;
            $outside      = isset($data[4]) ? (int)$data[4] : 1;
            $rawRate      = $data[5] ?? 0;

            // 3. Robust Rate Parsing
            $cleanRate = preg_replace('/[^0-9.]/', '', $rawRate); // Remove everything except numbers and dots
            $rate = is_numeric($cleanRate) ? (float)$cleanRate : 0;

            if (!$province || !$name) continue;

            // Fallback logic
            if (empty($city) && empty($municipality)) {
                $municipality = $name;
            }

            // 4. Update or Create
            DeliverableCities::updateOrCreate(
                [
                    'province' => $province,
                    'name'     => $name, // Now correctly encoded, it will match existing records
                ],
                [
                    'city'           => $city ?: null,
                    'municipality'   => $municipality ?: null,
                    'rate'           => $rate,
                    'outside_manila' => $outside,
                    'user_id'        => auth()->id(),
                    'area'           => null,
                    'item_type'      => null,
                    'barangay'       => null,
                ]
            );
        }

        fclose($handle);
        return back()->with('success', 'Locations uploaded successfully.');
    }

}
