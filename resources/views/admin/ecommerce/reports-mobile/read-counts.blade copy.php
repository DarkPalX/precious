@extends('admin.layouts.report')

@section('pagecss')
@endsection

@section('content')
<div style="margin: 40px 40px 200px 40px;font-family:Arial;">
    <h4 class="mg-b-0 tx-spacing--1">Read Counts</h4>
    
    <form action="{{route('report.read-counts.mobile')}}" method="get">
        <input type="hidden" name="act" value="go">
        @csrf
        <table style="font-size:12px;">
            <tr>
                <td>Start Date</td>
                <td>End Date</td>
            </tr>
            <tr>
                <td><input style="font-size:12px;width: 140px;" type="date" class="form-control input-sm" name="start" autocomplete="off"
                    value="{{$startDate}}">
                </td>
                <td><input style="font-size:12px;width: 140px;" type="date" class="form-control input-sm" name="end" autocomplete="off"
                    value="{{$endDate}}">
                </td>
                <td><button type="submit" class="btn btn-sm btn-primary" style="margin:0px 0px 0px 10px;">Generate</button></td>
                <td><a href="{{ route('report.downloads.mobile') }}" class="btn btn-sm btn-success" style="margin:0px 0px 0px 5px;">Reset</a></td>
            </tr>
        </table>
    </form>

    {{-- @if($rs <>'') --}}
    <br><br>
    <table id="example" class="ajax-table display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Read Counts</th>
            </tr>
        </thead>
    </table>

    {{-- <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
        <thead>
            <tr>
                <th align="left">Code</th>
                <th align="left">Name</th>
                <th align="left">Read Counts</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rs as $r)
            <tr>
                <td>{{$r->sku}}</td>
                <td>{{$r->name}}</td>
                <td>{{$r->read_count}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table> --}}
    {{-- @endif --}}
    
    {{-- <div class="row row-sm">

        <div class="col-md-6">
            <div class="mg-t-5">
                @if ($rs->firstItem() == null)
                    <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                @else
                    <p class="tx-gray-400 tx-12 d-inline">Showing {{ $rs->firstItem() }} to {{ $rs->lastItem() }} of {{ $rs->total() }} items</p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-md-right float-md-right mg-t-5">
                <div>
                    {{ $rs->links() }}
                </div>
            </div>
        </div>

    </div> --}}
</div>


@endsection

@section('pagejs')
    <script>

        $(document).ready(function () {

            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }

            $('.ajax-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('report.read-counts.mobile') }}",
                    type: "GET"
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
                pageLength: 20
            });
        });

    </script>
    {{-- <script>

        $(document).ready(function () {

            $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('report.read-counts.mobile') }}",
                    type: "GET"
                },
                columns: [
                    { data: 'sku' },
                    { data: 'name' },
                    { data: 'read_count' }
                ],
                pageLength: 20 // override parent default
            });

        });

    </script> --}}
@endsection


