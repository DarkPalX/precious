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
    <h4 class="mg-b-0 tx-spacing--1">Read Counts</h4>
    
    <form action="{{ route('report.read-counts.mobile') }}" method="get">
        <input type="hidden" name="act" value="go">
        @csrf
        <table style="font-size: 12px; margin-bottom: 15px;">
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

    <br>

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

        // Initialize main visible table
        $('.ajax-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false, // Prevents DataTables from calculating huge fixed widths
            ajax: {
                url: "{{ route('report.read-counts.mobile') }}",
                type: "GET",
                data: function (d) {
                    d.start = $('input[name="start"]').val();
                    d.end = $('input[name="end"]').val();
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
                    exportOptions: exportOptionsFiltered
                },
                {
                    extend: 'csv',
                    exportOptions: exportOptionsFiltered
                },
                {
                    extend: 'excel',
                    exportOptions: exportOptionsFiltered
                },
                {   
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: exportOptionsFiltered
                },
                'colvis'
            ],
            pageLength: 10000
        });

    });
</script>
@endsection