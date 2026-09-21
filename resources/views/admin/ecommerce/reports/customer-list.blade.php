@extends('admin.layouts.report')

@section('pagecss')
    <style>
        .customer-report-filters { display: flex; flex-wrap: wrap; align-items: end; gap: .75rem; margin-bottom: 1.5rem; }
        .customer-report-filters label { display: block; margin-bottom: .35rem; font-size: .75rem; font-weight: 600; color: #64748b; }
        .customer-report-filters .form-control { min-width: 150px; border-radius: .5rem; }
        #customer-export-loading { display: none; position: fixed; inset: 0; z-index: 9999; align-items: center; justify-content: center; background: rgba(15, 23, 42, .45); }
        #customer-export-loading .loading-card { display: flex; align-items: center; gap: .75rem; padding: 1rem 1.25rem; border-radius: .75rem; background: #fff; color: #1e293b; font-size: .875rem; font-weight: 600; box-shadow: 0 10px 30px rgba(15, 23, 42, .2); }
        #customer-export-loading .spinner { width: 1.25rem; height: 1.25rem; border: 3px solid #cbd5e1; border-top-color: #1b365d; border-radius: 50%; animation: customer-export-spin .7s linear infinite; }
        @keyframes customer-export-spin { to { transform: rotate(360deg); } }
    </style>
@endsection

@section('content')
    <div id="customer-export-loading" aria-live="polite" aria-busy="true">
        <div class="loading-card"><span class="spinner"></span><span>Preparing export, please wait...</span></div>
    </div>

    <div style="margin:0px 40px 200px 40px;font-family:Arial;">
        <br><br>
        <h2 class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-100">Customers List Report</h2>

        <form action="{{ route('report.customer-list') }}" method="get" class="customer-report-filters">
            <div>
                <label for="start">Date from</label>
                <input id="start" type="date" name="start" class="form-control form-control-sm" value="{{ $startDate }}">
            </div>
            <div>
                <label for="end">Date to</label>
                <input id="end" type="date" name="end" class="form-control form-control-sm" value="{{ $endDate }}">
            </div>
            <div>
                <label for="platform">Platform</label>
                <select id="platform" name="platform" class="form-control form-control-sm">
                    <option value="">All platforms</option>
                    <option value="mobile" {{ $platform === 'mobile' ? 'selected' : '' }}>Mobile</option>
                    <option value="web" {{ $platform === 'web' ? 'selected' : '' }}>Web</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Generate</button>
            <a href="{{ route('report.customer-list') }}" class="btn btn-sm btn-success">Reset</a>
        </form>

        <div class="table-responsive">
            <table id="customer-report" class="display nowrap" style="width:100%;font-size:13px;">
                <thead>
                    <tr>
                        <th>Name</th><th>Email</th><th>Mobile</th><th>Address</th>
                        <th>Account Created</th><th>Platform</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('customjs')
    <script>
        $(function () {
            function showExportLoading() {
                $('#customer-export-loading').css('display', 'flex');
            }

            function hideExportLoading() {
                $('#customer-export-loading').hide();
            }

            function exportAllFromServer(e, dt, button, config, builtInName) {
                showExportLoading();
                $.ajax({
                    url: "{{ route('report.customer-list') }}",
                    type: 'GET',
                    data: {
                        start_date: $('input[name="start"]').val(),
                        end_date: $('input[name="end"]').val(),
                        platform: $('select[name="platform"]').val(),
                        start: 0,
                        length: -1,
                        is_export: 1
                    },
                    success: function (response) {
                        const exportTable = $('<table>')
                            .append('<thead><tr><th>Name</th><th>Email</th><th>Mobile</th><th>Address</th><th>Account Created</th><th>Platform</th></tr></thead>')
                            .appendTo('body')
                            .hide();
                        const exportConfig = $.extend(true, {}, config);
                        delete exportConfig.action;
                        exportConfig.extend = builtInName;
                        exportConfig.exportOptions = $.extend(true, {}, exportConfig.exportOptions, {
                            columns: [0, 1, 2, 3, 4, 5],
                            modifier: { page: 'all' }
                        });

                        const exportDt = exportTable.DataTable({
                            data: response.data,
                            columns: [
                                { data: 'customer_name' },
                                { data: 'email' },
                                { data: 'mobile' },
                                { data: 'address' },
                                { data: 'account_created' },
                                { data: 'platform' }
                            ],
                            paging: false,
                            searching: false,
                            ordering: false,
                            dom: 'B t',
                            buttons: [exportConfig]
                        });

                        exportDt.button(0).trigger();
                        exportDt.destroy();
                        exportTable.remove();
                        hideExportLoading();
                    },
                    error: function () {
                        hideExportLoading();
                        alert('The export could not be prepared. Please try again.');
                    }
                });
            }

            const customerTable = $('#customer-report').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    processing: 'Loading customers...'
                },
                ajax: {
                    url: "{{ route('report.customer-list') }}",
                    data: function (data) {
                        data.start_date = $('input[name="start"]').val();
                        data.end_date = $('input[name="end"]').val();
                        data.platform = $('select[name="platform"]').val();
                    }
                },
                columns: [
                    { data: 'customer_name', name: 'firstname' },
                    { data: 'email', name: 'email' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'address', name: 'address_street', orderable: false },
                    { data: 'account_created', name: 'email_verified_at' },
                    { data: 'platform', name: 'verification_code', orderable: false }
                ],
                dom: 'Bfrtip',
                paging: true,
                pageLength: 20,
                lengthMenu: [[20], [20]],
                order: [[4, 'desc']],
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: { columns: ':visible' },
                        action: function (e, dt, button, config) {
                            exportAllFromServer(e, dt, button, config, 'print');
                        }
                    },
                    {
                        extend: 'csv',
                        action: function () {
                            showExportLoading();
                            const params = new URLSearchParams({
                                start: $('input[name="start"]').val() || '',
                                end: $('input[name="end"]').val() || '',
                                platform: $('select[name="platform"]').val() || '',
                                export: 'csv'
                            });
                            window.location.href = "{{ route('report.customer-list') }}?" + params.toString();
                            setTimeout(hideExportLoading, 3000);
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: { columns: ':visible' },
                        action: function (e, dt, button, config) {
                            exportAllFromServer(e, dt, button, config, 'excelHtml5');
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        exportOptions: { columns: ':visible' },
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        action: function (e, dt, button, config) {
                            exportAllFromServer(e, dt, button, config, 'pdfHtml5');
                        }
                    },
                    'colvis'
                ]
            });

            $('select[name="platform"]').on('change', function () {
                customerTable.ajax.reload(null, true);
            });
        });
    </script>
@endsection
