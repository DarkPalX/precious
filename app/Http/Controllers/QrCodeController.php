<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate($file_url)
    {
        // Decoding the URL parameter
        $file_url = urldecode($file_url);

        // Return the QR code as an image
        return response(QrCode::size(300)->generate($file_url))
            ->header('Content-Type', 'image/png');
    }
}
