<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Ecommerce\Product;


class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        // Retrieve the file_url parameter from the request
        $file_url = $product->file_url;

        // Decode the URL parameter
        $file_url = urldecode($file_url);

        // For debugging: Log the file_url to ensure it's received correctly
        \Log::info('Generating QR code for URL: ' . $file_url);

        // Generate the QR code as an SVG
        $qrCode = QrCode::size(300)->generate(env('APP_URL') . '/public/' . $file_url);

        // Pass the QR code to the view
        return view('admin.ecommerce.products.file-qr', compact('qrCode', 'product'));
    }
    
    // public function generate(Request $request)
    // {
    //     // Retrieve the file_url parameter from the request
    //     $file_url = $request->query('file_url');

    //     // Decode the URL parameter
    //     $file_url = urldecode($file_url);

    //     // For debugging: Log the file_url to ensure it's received correctly
    //     \Log::info('Generating QR code for URL: ' . $file_url);

    //     // Generate the QR code as an SVG
    //     $qrCode = QrCode::size(300)->generate(env('APP_URL') . '/public/' . $file_url);

    //     // Pass the QR code to the view
    //     return view('admin.ecommerce.products.file-qr', compact('qrCode'));
    // }
}

