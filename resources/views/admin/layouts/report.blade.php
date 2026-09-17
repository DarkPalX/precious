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
    
    <!-- Google Fonts for Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            color: #475569 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 0.4rem 0.85rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease !important;
        }
        .dataTables_wrapper .dt-buttons .dt-button:hover {
            background: #f8fafc !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
            transform: translateY(-1px);
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.5rem !important;
            padding: 0.35rem 0.75rem !important;
            outline: none !important;
            font-size: 0.875rem !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }
    </style>

    @yield('pagecss')
</head>

<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white dark:bg-slate-950 dark:text-slate-100">

    <!-- Reduced outer padding and increased container width -->
    <div class="min-h-screen p-2 sm:p-4 lg:p-6">
        <div class="mx-auto max-w-[95%] space-y-4">
            
            <!-- Header Container -->
            <header class="relative overflow-hidden rounded-xl border border-slate-200/80 bg-white/80 p-5 text-center shadow-xs backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/80">
                <div class="pointer-events-none absolute -top-12 left-1/2 h-32 w-72 -translate-x-1/2 rounded-full bg-indigo-500/10 blur-3xl"></div>

                <div class="relative z-10">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-500 ring-1 ring-slate-900/5 dark:bg-slate-800 dark:text-slate-400 dark:ring-white/10">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        System Generated Report
                    </span>
                    
                    <h2 class="mt-2 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 bg-clip-text text-xl font-black uppercase tracking-[0.25em] text-transparent sm:text-2xl dark:from-white dark:via-indigo-200 dark:to-slate-200">
                        Precious Pages Corporation
                    </h2>
                    
                    <div class="mx-auto mt-2 flex w-20 items-center justify-center gap-1.5">
                        <span class="h-0.5 w-full rounded-full bg-indigo-500/30"></span>
                        <span class="h-1 w-1 shrink-0 rounded-full bg-indigo-600"></span>
                        <span class="h-0.5 w-full rounded-full bg-indigo-500/30"></span>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="rounded-xl border border-slate-200/80 bg-white p-4 sm:p-6 shadow-xs dark:border-slate-800 dark:bg-slate-900">
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
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrti',
                pageLength: 1000,
                order: [[0, 'desc']],
                buttons: [
                    { extend: 'print', exportOptions: { columns: ':visible' } },
                    { extend: 'copy', exportOptions: { columns: ':visible' } },
                    { extend: 'csv', exportOptions: { columns: ':visible' } },
                    { extend: 'excel', exportOptions: { columns: ':visible' } },
                    { 
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        exportOptions: { modifier: { page: 'current' } },
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    'colvis'
                ],
                columnDefs: [ { visible: false } ],
                language: {
                    info: "",
                    infoEmpty: "",
                    infoFiltered: "",
                    lengthMenu: "Show _MENU_ entries"
                }
            });
        });
    </script>

    @yield('pagejs')
    @yield('customjs')

</body>
</html>