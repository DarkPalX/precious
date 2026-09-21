<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ App\Models\Setting::getWebsiteName() }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage').'/icons/'.Setting::getFaviconLogo()->website_favicon }}">
    
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('js/datatables/datatables.css') }}">

    <!-- Vendor CSS -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashforge.dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin.deepblue.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    
    <!-- Custom Brand Fonts: Fredoka & Outfit for Precious Pages logo style -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Typography Matching Logo */
        .font-brand-title {
            font-family: 'Fredoka', cursive, sans-serif;
        }
        .font-brand-sub {
            font-family: 'Outfit', sans-serif;
        }

        /* Aesthetic DataTables Custom Overrides */
        .dataTables_wrapper .dt-buttons {
            margin-bottom: 1.25rem !important;
            display: inline-flex !important;
            gap: 0.375rem !important;
        }
        .dataTables_wrapper .dt-buttons .dt-button {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.5rem !important;
            color: #1e293b !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 0.4rem 0.85rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .dataTables_wrapper .dt-buttons .dt-button:hover {
            background: #1b365d !important;
            color: #ffffff !important;
            border-color: #1b365d !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(27, 54, 93, 0.2) !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 0.35rem 0.75rem !important;
            outline: none !important;
            font-size: 0.875rem !important;
            transition: border-color 0.2s ease !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #1b365d !important;
            box-shadow: 0 0 0 3px rgba(27, 54, 93, 0.15) !important;
        }

        .report-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }
        .report-toolbar h2,
        .report-toolbar h4 {
            flex: 1 1 auto;
            margin: 0 !important;
            white-space: nowrap;
        }
        .report-toolbar form {
            flex: 0 0 auto;
            max-width: none;
            overflow-x: visible;
            margin: 0 0 0 auto !important;
        }
        .report-toolbar form.wide-filter {
            flex: 0 1 auto;
            max-width: calc(100% - 260px);
            overflow-x: auto;
        }
        .report-toolbar form table {
            margin: 0 !important;
        }
        #report-export-loading {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 99999;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, .45);
        }
        #report-export-loading .loading-card {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.25rem;
            border-radius: .75rem;
            background: #fff;
            color: #1e293b;
            font-size: .875rem;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .2);
        }
        #report-export-loading .spinner {
            width: 1.25rem;
            height: 1.25rem;
            border: 3px solid #cbd5e1;
            border-top-color: #1b365d;
            border-radius: 50%;
            animation: report-export-spin .7s linear infinite;
        }
        @keyframes report-export-spin { to { transform: rotate(360deg); } }
        @media (max-width: 768px) {
            .report-toolbar {
                align-items: stretch;
                flex-direction: column;
                gap: 0.75rem;
            }
            .report-toolbar form {
                max-width: 100%;
            }
            .report-toolbar h2,
            .report-toolbar h4 {
                white-space: normal;
            }
        }
    </style>

    @yield('pagecss')
</head>

<body class="bg-slate-100/70 text-slate-800 antialiased selection:bg-slate-800 selection:text-white dark:bg-slate-950 dark:text-slate-100">

    <div id="report-export-loading" aria-live="polite" aria-busy="true">
        <div class="loading-card"><span class="spinner"></span><span>Preparing export, please wait...</span></div>
    </div>

    <div class="min-h-screen p-3 sm:p-5 lg:p-6">
        <div class="mx-auto max-w-[96%] space-y-5 transition-all duration-300">
            
            <!-- Clean Header Container with Blue Typography -->
            <header class="relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white/90 px-6 py-6 text-center shadow-xs backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/90">
                
                <!-- Gentle Ambient Glow -->
                <div class="pointer-events-none absolute -top-12 left-1/2 h-32 w-72 -translate-x-1/2 rounded-full bg-blue-500/10 blur-3xl"></div>

                <div class="relative z-10 flex flex-col items-center justify-center">
                    
                    <!-- Main Logo Title in Deep Brand Blue -->
                    <h1 class="font-brand-title text-3xl font-extrabold tracking-wide text-[#1b365d] dark:text-blue-400 sm:text-4xl md:text-5xl">
                        Precious Pages
                    </h1>
                    
                    <!-- Subtitle Style in Deep Blue -->
                    <span class="font-brand-sub mt-0.5 text-xs font-bold tracking-[0.35em] text-[#1b365d]/80 uppercase dark:text-blue-300/80 sm:text-sm">
                        Bookstore
                    </span>
                    
                    <!-- Minimalist Separator Badge -->
                    <div class="mt-4 flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 ring-1 ring-slate-900/5 dark:bg-slate-800 dark:ring-white/10">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold tracking-widest text-slate-500 uppercase dark:text-slate-400">System Generated Report</span>
                    </div>

                </div>
            </header>

            <!-- Main Dynamic Report Body -->
            <main class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs transition-all duration-300 dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/datatables/JSZip-2.5.0/jszip.min.js') }}"></script>
    <script src="{{ asset('js/datatables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/datatables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.print.min.js') }}"></script>

    <script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('js/dashforge.js') }}"></script>

    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(document).on('click', '.dt-button', function() {
            var buttonText = $(this).text().trim().toLowerCase();
            var isExportButton = ['print', 'csv', 'excel', 'pdf'].some(function (type) {
                return buttonText.indexOf(type) === 0;
            });

            if (!isExportButton) {
                return;
            }

            $('#report-export-loading').css('display', 'flex');
            // Standard client-side exports finish immediately. Server-side
            // exports use their own request and are covered by this timeout.
            window.setTimeout(function () {
                $('#report-export-loading').hide();
            }, 5000);
        });

        $(document).ready(function() {
            $('main h2, main h4').each(function() {
                var $title = $(this);
                var $form = $title.closest('main').find('form').first();
                var $toolbar = $('<div class="report-toolbar"></div>');

                $toolbar.insertBefore($title);
                $toolbar.append($title);
                if ($form.length) {
                    if ($form.find('td').length > 8) {
                        $form.addClass('wide-filter');
                    }
                    $toolbar.append($form);
                }
            });

        });

        // Some legacy report templates contain a disabled/old initializer.
        // Initialize only tables that are still untouched by their page script.
        $(window).on('load', function() {
            $('table.display').each(function() {
                if ($.fn.DataTable.isDataTable(this)) {
                    return;
                }

                $(this).DataTable({
                    dom: 'Bfrtip',
                    pageLength: 20,
                    buttons: [
                        { extend: 'print', exportOptions: { columns: ':visible', modifier: { page: 'all' } } },
                        { extend: 'csv', exportOptions: { columns: ':visible', modifier: { page: 'all' } } },
                        { extend: 'excel', exportOptions: { columns: ':visible', modifier: { page: 'all' } } },
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            exportOptions: { columns: ':visible', modifier: { page: 'all' } },
                            orientation: 'landscape',
                            pageSize: 'LEGAL'
                        },
                        'colvis'
                    ]
                });
            });
        });
    </script>

    @yield('pagejs')
    @yield('customjs')

</body>
</html>
