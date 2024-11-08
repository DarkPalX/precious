@extends('admin.layouts.report')

@section('pagecss')
@endsection

@section('content')
<div style="margin: 40px 40px 200px 40px;font-family:Arial;">
    <h4 class="mg-b-0 tx-spacing--1">Subscribers List</h4>
    @if($rs <>'')
    <br><br>
    <table id="subscribers" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
        <thead>
            <tr>
                <th align="left">Name</th>
                <th align="left">Email</th>
                <th align="left">Contact #</th>
                <th align="left">Subscription</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rs as $r)
                @php 
                    $user_subs = \App\Models\UsersSubscription::getSubscriptions($r->id);
                @endphp
                
                <tr>
                    <td>{{$r->fullname}}</td>
                    <td>{{$r->email}}</td>
                    <td>{{$r->mobile}}</td>
                    <td>
                        @foreach($user_subs as $user_sub)
                            {{ \App\Models\Subscription::getPlan($user_sub->plan_id)[0]->title }}<br>
                            <span class="text-secondary">expires on {{ Setting::date_for_listing($user_sub->end_date) }}</span><br>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No subscribers found.</td>
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
        $('#subscribers').DataTable( {
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



