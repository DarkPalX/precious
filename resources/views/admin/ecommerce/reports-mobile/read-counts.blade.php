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

        // Custom Export/Print Handler
        // Fetches ALL records silently in the background and mounts them to an off-screen DOM element
        var newExportAction = function (e, dt, button, config) {
            var self = this;
            
            // Prepare AJAX parameters for all records (length = -1)
            var params = $.extend({}, dt.ajax.params(), {
                start: 0,
                length: -1
            });

            // Show processing indicator on main table
            dt.processing(true);

            // Fetch complete dataset
            $.ajax({
                url: "{{ route('report.read-counts.mobile') }}",
                type: 'GET',
                data: params,
                success: function (json) {
                    dt.processing(false);

                    // 1. Create off-screen container and append to DOM (required by Print extension)
                    var $container = $('<div style="position: absolute; left: -9999px; top: -9999px;"></div>');
                    var $tempTable = $('<table class="display nowrap" style="width:100%">').append($('#example thead').clone());
                    
                    $container.append($tempTable);
                    $('body').append($container);

                    // 2. Initialize temporary DataTables instance with full dataset
                    var tempDt = $tempTable.DataTable({
                        dom: 'Bfrtip',
                        data: json.data,
                        columns: [
                            { data: 'sku' },
                            { data: 'name' },
                            { data: 'read_count' }
                        ],
                        paging: false,
                        searching: false,
                        info: false
                    });

                    // 3. Trigger requested export/print action against full dataset
                    $.fn.dataTable.ext.buttons[config.extend].action.call(self, e, tempDt, button, config);

                    // 4. Delay destruction by 1 second to give print preview engine time to read DOM
                    setTimeout(function () {
                        tempDt.destroy();
                        $container.remove();
                    }, 1000);
                },
                error: function () {
                    dt.processing(false);
                    alert('Export failed. Please try again.');
                }
            });
        };

        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        // Initialize visible table
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
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {   
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    },
                    orientation : 'landscape',
                    pageSize : 'LEGAL'
                },
                'colvis'
            ],
            // buttons: [
            //     {
            //         extend: 'print',
            //         exportOptions: { columns: ':visible' },
            //         action: newExportAction
            //     },
            //     {
            //         extend: 'csv',
            //         exportOptions: { columns: ':visible' },
            //         action: newExportAction
            //     },
            //     {
            //         extend: 'excel',
            //         exportOptions: { columns: ':visible' },
            //         action: newExportAction
            //     },
            //     {   
            //         extend: 'pdfHtml5',
            //         text: 'PDF',
            //         exportOptions: { columns: ':visible' },
            //         orientation: 'landscape',
            //         pageSize: 'LEGAL',
            //         action: newExportAction
            //     },
            //     'colvis'
            // ],
            pageLength: 10000
        });

    });
</script>
@endsection