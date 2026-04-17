<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="SemiColonWeb" />

        <!-- Stylesheets
        ============================================= -->
        <link rel="stylesheet" href="{{ asset('theme/css/bootstrap.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/swiper.css') }}" type="text/css" />

        <!-- Construction Demo Specific Stylesheet -->
        <!-- / -->
        
        <link rel="stylesheet" href="{{ asset('theme/css/dark.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/font-icons.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/animate.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/magnific-popup.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/slick.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/slick-theme.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/fontawesome.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('theme/css/cookiealert.css') }}" type="text/css"  />
        <link rel="stylesheet" href="{{ asset('theme/css/fonts.css') }}" type="text/css"  />
        <link rel="stylesheet" href="{{ asset('theme/css/cafe.css') }}" type="text/css"  />
        <link rel="stylesheet" href="{{ asset('theme/css/components/bs-filestyle.css') }}" type="text/css"  />
        
        <link rel="stylesheet" href="{{ asset('theme/css/custom.css') }}" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="{{ asset('storage').'/icons/'.Setting::getFaviconLogo()->website_favicon }}" type="image/x-icon">
    </head>
    <body>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">

                            <h3 class="mb-3">Bank Payment</h3>
                            <p class="text-muted mb-4">
                                Transfer the exact amount to the account below, then submit your payment details for verification.
                            </p>

                            {{-- BANK DETAILS --}}
                            <div class="alert alert-info mb-4">
                                <h6 class="mb-2"><strong>Precious Pages Bank Details</strong></h6>
                                <div><strong>Bank:</strong> BDO Unibank</div>
                                <div><strong>Account Name:</strong> Precious Pages</div>
                                <div><strong>Account Number:</strong> 1234-5678-90</div>
                            </div>

                            {{-- TOTAL --}}
                            @if(session('transaction_info_request'))
                                @php $data = session('transaction_info_request'); @endphp

                                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                                    <span class="text-muted">Total Amount</span>
                                    <h4 class="mb-0 text-primary">
                                        ₱ {{ number_format($data['total_amount'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            @endif

                            <hr>

                            <h5 class="mb-3 mt-4">Payment Confirmation</h5>
                            <p class="text-muted mb-4">
                                Fill in your bank details and upload proof of payment.
                            </p>

                            {{-- FORM --}}
                            <form action="{{-- route('bank.confirm') --}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Your Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control form-control-lg" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Your Account Number</label>
                                    <input type="text" name="account_number" class="form-control form-control-lg" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Purpose</label>
                                    <textarea name="purpose" class="form-control" rows="3" placeholder="e.g. Payment for order #123" required></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Upload Proof of Payment</label>
                                    <input type="file" name="attachment" class="form-control" accept="image/*,.pdf" required>
                                    <small class="text-muted">Accepted: JPG, PNG, PDF (Max 2MB)</small>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Submit Payment
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </body>
</html>