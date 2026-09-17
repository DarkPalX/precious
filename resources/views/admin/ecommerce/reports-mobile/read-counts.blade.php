@extends('admin.layouts.report')

@section('pagecss')
<style>
    /* Prevent table cell content from breaking out and enforce word wrap */
    #example td, #example th {
        white-space: normal !important;
        word-wrap: break-word;
    }
</style>
@endsection

@section('content')
<div style="margin: 20px 15px 100px 15px; font-family: Arial;">
    
   <div class="flex items-end justify-between mb-3">
        <h2 class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-100">Read Counts Report</h2>

        <form action="{{ route('report.read-counts.mobile') }}" method="get">
            <input type="hidden" name="act" value="go">
            @csrf
            <table style="font-size: 12px; margin-bottom: 0;">
                <tr>
                    <td>Start Date</td>
                    <td>End Date</td>
                </tr>
                <tr>
                    <td>
                        <input style="font-size: 12px; width: 130px;" type="date" class="form-control input-sm" name="start" autocomplete="off" value="{{ $startDate }}">
                    </td>
                    <td>
                        <input style="font-size: 12px; width: 130px;" type="date" class="form-control input-sm" name="end" autocomplete="off" value="{{ $endDate }}">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-sm btn-primary" style="margin-left: 5px;">Generate</button>
                    </td>
                    <td>
                        <a href="{{ route('report.read-counts.mobile') }}" class="btn btn-sm btn-success" style="margin-left: 5px;">Reset</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    


    <!-- Scroll wrapper guarantees the page layout will never break -->
    <div style="width: 100%; overflow-x: auto;">
        <table id="example" class="ajax-table display" style="width: 100%; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 20%;">Code</th>
                    <th style="width: 40%;">Name</th>
                    <th style="width: 25%;">Author</th>
                    <th style="width: 15%;">Read Counts</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('pagejs')
<script>
    $(document).ready(function () {

        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        // Export rule: Only include visible columns and rows where read_count > 0
        var exportOptionsFiltered = {
            columns: ':visible',
            rows: function (idx, data, node) {
                return Number(data.read_count) > 0;
            }
        };

        function exportCsvFromServer() {
            var params = new URLSearchParams({
                start_date: $('input[name="start"]').val() || '',
                end_date: $('input[name="end"]').val() || '',
                export: 'csv'
            });

            window.location.href = "{{ route('report.read-counts.mobile') }}?" + params.toString();
        }

        // Fetch all export rows into a hidden DataTable. The visible table
        // remains server-side paginated at 20 rows and is never changed.
        function exportAllFromServer(e, dt, button, config, builtInName) {
            $.ajax({
                url: "{{ route('report.read-counts.mobile') }}",
                type: 'GET',
                data: {
                    start_date: $('input[name="start"]').val(),
                    end_date: $('input[name="end"]').val(),
                    start: 0,
                    length: -1,
                    is_export: 1
                },
                success: function (response) {
                    var exportTable = $('<table>')
                        .append('<thead><tr><th>Code</th><th>Name</th><th>Author</th><th>Read Counts</th></tr></thead>')
                        .appendTo('body')
                        .hide();
                    var exportConfig = $.extend(true, {}, config);
                    delete exportConfig.action;
                    exportConfig.extend = builtInName;
                    exportConfig.exportOptions = $.extend(true, {}, exportConfig.exportOptions, {
                        // The temporary table is hidden, so ':visible' would
                        // select no columns for Excel/PDF/Print exports.
                        columns: [0, 1, 2, 3],
                        modifier: { page: 'all' }
                    });

                    var exportDt = exportTable.DataTable({
                        data: response.data,
                        columns: [
                            { data: 'sku' },
                            { data: 'name' },
                            { data: 'author' },
                            { data: 'read_count' }
                        ],
                        paging: false,
                        searching: false,
                        ordering: false,
                        dom: 'B t',
                        buttons: [exportConfig]
                    });

                    // Let Buttons resolve and execute its own built-in action.
                    exportDt.button(0).trigger();
                    exportDt.destroy();
                    exportTable.remove();
                }
            });
        }

        // Initialize main visible table
        $('.ajax-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false, // Prevents DataTables from calculating huge fixed widths
            ajax: {
                url: "{{ route('report.read-counts.mobile') }}",
                type: "GET",
                data: function (d) {
                    d.start_date = $('input[name="start"]').val();
                    d.end_date = $('input[name="end"]').val();
                }
            },
            columns: [
                { data: 'sku', width: '20%' },
                { data: 'name', width: '40%' },
                { data: 'author', width: '25%' },
                { data: 'read_count', width: '15%' }
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: exportOptionsFiltered,
                    action: function (e, dt, button, config) {
                        exportAllFromServer(e, dt, button, config, 'print');
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: exportOptionsFiltered,
                    action: exportCsvFromServer
                },
                {
                    extend: 'excel',
                    exportOptions: exportOptionsFiltered,
                    action: function (e, dt, button, config) {
                        exportAllFromServer(e, dt, button, config, 'excelHtml5');
                    }
                },
                {   
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: exportOptionsFiltered,
                    action: function (e, dt, button, config) {
                        exportAllFromServer(e, dt, button, config, 'pdfHtml5');
                    }
                },
                'colvis'
            ],
            paging: true,
            pageLength: 20,
            lengthMenu: [[20], [20]]
        });

    });
</script>
@endsection
