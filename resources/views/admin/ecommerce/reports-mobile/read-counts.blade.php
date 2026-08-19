@extends('admin.layouts.report')

@section('pagecss')
@endsection

@section('content')
<div style="margin: 40px 40px 200px 40px; font-family: Arial;">
    <h4 class="mg-b-0 tx-spacing--1">Read Counts</h4>
    
    <form action="{{ route('report.read-counts.mobile') }}" method="get">
        <input type="hidden" name="act" value="go">
        @csrf
        <table style="font-size: 12px;">
            <tr>
                <td>Start Date</td>
                <td>End Date</td>
            </tr>
            <tr>
                <td>
                    <input style="font-size: 12px; width: 140px;" type="date" class="form-control input-sm" name="start" autocomplete="off" value="{{ $startDate }}">
                </td>
                <td>
                    <input style="font-size: 12px; width: 140px;" type="date" class="form-control input-sm" name="end" autocomplete="off" value="{{ $endDate }}">
                </td>
                <td>
                    <button type="submit" class="btn btn-sm btn-primary" style="margin: 0px 0px 0px 10px;">Generate</button>
                </td>
                <td>
                    <a href="{{ route('report.read-counts.mobile') }}" class="btn btn-sm btn-success" style="margin: 0px 0px 0px 5px;">Reset</a>
                </td>
            </tr>
        </table>
    </form>

    <br><br>

    <table id="example" class="ajax-table display nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Read Counts</th>
            </tr>
        </thead>
    </table>
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

        // Initialize main visible table (Displays 0 read counts)
        $('.ajax-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('report.read-counts.mobile') }}",
                type: "GET",
                data: function (d) {
                    d.start = $('input[name="start"]').val();
                    d.end = $('input[name="end"]').val();
                }
            },
            columns: [
                { data: 'sku' },
                { data: 'name' },
                { data: 'read_count' }
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