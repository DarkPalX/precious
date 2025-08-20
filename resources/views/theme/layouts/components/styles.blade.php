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

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4238943947470545" crossorigin="anonymous"></script>

    <style>
        @php
            $jsStyle = str_replace(array("'", "&#039;"), "", old('styles', $page->styles) );
            echo $jsStyle;
        @endphp
    </style>
    <!-- Document Title
    ============================================= -->
    @if (isset($page->name) && $page->name == 'Home')
        <title>{{ Setting::info()->company_name }}</title>
    @else
        <title>{{ (empty($page->meta_title) ? $page->name:$page->meta_title) }} | {{ Setting::info()->company_name }}</title>
    @endif

    @if(!empty($page->meta_description))
        <meta name="description" content="{{ $page->meta_description }}">
    @endif

    @if(!empty($page->meta_keyword))
        <meta name="keywords" content="{{ $page->meta_keyword }}">
    @endif

    @yield('pagecss')
</head>