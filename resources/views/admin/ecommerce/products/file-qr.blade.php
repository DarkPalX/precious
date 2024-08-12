@extends('admin.layouts.app')

@section('pagecss')
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <style>
        .row-selected {
            background-color: #92b7da !important;
        }

        .qr-code-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height of the viewport */
        }

        .qr-code {
            max-width: 100%; /* Ensure the QR code is responsive */
        }
    </style>
@endsection

@section('content')
    <div class="container pd-x-0 qr-code-container">
        <!-- Display the QR code -->
        {!! $qrCode !!}
    </div>
@endsection

@section('pagejs')
@endsection
