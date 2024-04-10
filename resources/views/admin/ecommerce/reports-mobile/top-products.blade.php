@extends('admin.layouts.report')

@section('pagecss')
@endsection

@section('content')
<div style="margin: 40px 40px 200px 40px;font-family:Arial;">
    <h4 class="mg-b-0 tx-spacing--1">Top Rated Products</h4>
    @if($rs <>'')
    <br><br>
    <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
        <thead>
            <tr>
                <th align="left">Items</th>
                <th align="left">Average Rating</th>
                <th align="left">No. of Reviews</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rs as $r)
            <tr>
                <td>{{$r->product->name ?? $r->product_name}}</td>
                <td>{{number_format($r->average_rating,2)}}</td>
                <td>{{$r->review_count}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No item.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif
</div>


@endsection

@section('pagejs')
@endsection

@section('customjs')
<script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.colVis.min.js') }}"></script>
<script>


    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            pageLength: 20,
            order: [[0,'desc']],
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
            columnDefs: [ {

                visible: false
            } ]
        } );
    } );
</script>
@endsection



