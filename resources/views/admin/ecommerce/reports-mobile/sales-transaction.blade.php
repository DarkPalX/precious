@extends('admin.layouts.report')

@section('pagecss')
@endsection

@section('content')
<div style="margin:0px 40px 200px 40px;font-family:Arial;">
    <br><br>
    <h4 class="mg-b-0 tx-spacing--1">Mobile Sales Transaction Report</h4>
    <form action="{{route('report.sales-transaction.mobile')}}" method="get">
        <input type="hidden" name="act" value="go">
        @csrf
        <table style="font-size:12px;">
            <tr>
                <td>Start Date</td>
                <td>End Date</td>
                <td>Client/Customer Name</td>
                <td>Item/Purchase Description</td>
                <td>Product Category</td>
                <td>Status</td>
            </tr>
            <tr>
                <td><input style="font-size:12px;width: 140px;" type="date" class="form-control input-sm" name="start" autocomplete="off" value="{{$startDate}}"></td>
                <td><input style="font-size:12px;width: 140px;" type="date" class="form-control input-sm" name="end" autocomplete="off" value="{{$endDate}}"></td>
                <td>
                    <select style="font-size:12px;width: 140px;" name="customer" id="customer" class="form-control input-sm">
                        <option value="">Select</option>
                        @php $customers = \App\Models\User::where('role_id','6')->orderBy('name')->get(); @endphp
                        @forelse($customers as $cu)
                            <option value="{{$cu->fullname}}" @if(isset($customer) and $customer == $cu->fullname) selected="selected" @endif>{{$cu->name}}</option>
                        @empty
                        @endforelse
                    </select>
                </td>
                <td>
                    <select style="font-size:12px;width: 140px;" name="product" id="product" class="form-control input-sm">
                        <option value="">Select</option>
                        @php $products = \App\Models\Ecommerce\Product::orderBy('name')->get(); @endphp
                        @forelse($products as $p)
                            <option value="{{$p->name}}" @if(isset($product) and $product == $p->name) selected="selected" @endif>{{$p->name}}</option>
                        @empty
                        @endforelse
                    </select>
                </td>
                <td>
                    <select style="font-size:12px;width: 140px;" name="category" id="category" class="form-control input-sm">
                        <option value="">Select</option>
                        @php $categories = \App\Models\Ecommerce\ProductCategory::orderBy('name')->get(); @endphp
                        @forelse($categories as $c)
                            <option value="{{$c->id}}" @if(isset($category) && $category == $c->id) selected="selected" @endif>{{$c->name}}</option>
                        @empty
                        @endforelse
                    </select>
                </td>
                <td>
                    <select style="font-size:12px;width: 140px;" name="del_status" id="del_status" class="form-control input-sm">
                        <option value="">Select</option>
                        <option @if(isset($status) && $status == 'Pending') selected="selected" @endif value="Pending">Pending</option>
                        <option @if(isset($status) && $status == 'Processing') selected="selected" @endif value="Processing">Processing</option>
                        <option @if(isset($status) && $status == 'In Transit') selected="selected" @endif value="In Transit">In Transit</option>
                        <option @if(isset($status) && $status == 'Delivered') selected="selected" @endif value="Delivered">Delivered</option>
                        <option @if(isset($status) && $status == 'Returned') selected="selected" @endif value="Returned">Returned</option>
                        <option @if(isset($status) && $status == 'Cancelled') selected="selected" @endif value="Cancelled">Cancelled</option>                                    
                    </select>
                </td>
                <td><button type="submit" class="btn btn-sm btn-primary" style="margin:0px 0px 0px 10px;">Generate</button></td>
                <td><a href="{{ route('report.sales-transaction.mobile') }}" class="btn btn-sm btn-success" style="margin:0px 0px 0px 5px;">Reset</a></td>
            </tr>
        </table>
    </form>

    <br><br>
    <table id="sales-table" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction Ref#</th>
                <th>Customer No.</th>
                <th>Client/Customer Name</th>
                <th>Delivery Address</th>
                <th>Item/Purchase Description</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Gross</th>
                <th>Discount</th>
                <th>Net Price</th>
                <th>Payment Method</th>
                <th>Status</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('pagejs')
<script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
<script src="{{ asset('lib/prismjs/prism.js') }}"></script>
<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
@endsection

@section('customjs')
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#sales-table')) {
            $('#sales-table').DataTable().destroy();
        }

        $('#sales-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('report.sales-transaction.mobile') }}",
                type: "GET",
                data: function(d) {
                    d.start = $('input[name="start"]').val();
                    d.end = $('input[name="end"]').val();
                    d.customer = $('#customer').val();
                    d.product = $('#product').val();
                    d.category = $('#category').val();
                    d.del_status = $('#del_status').val();
                }
            },
            columns: [
                { data: 'date', name: 'ecommerce_sales_headers.created_at' },
                { data: 'order_number', name: 'ecommerce_sales_headers.order_number' }, 
                { data: 'customer_no', name: 'header.user.id', orderable: false },
                { data: 'client_name', name: 'ecommerce_sales_headers.customer_name', orderable: false }, 
                { data: 'customer_delivery_adress', name: 'ecommerce_sales_headers.customer_delivery_adress' },
                { data: 'product_name', name: 'ecommerce_sales_details.product_name' },
                { data: 'category_name', name: 'product.category.name', orderable: false },
                { data: 'qty', name: 'ecommerce_sales_details.qty', className: 'text-right' },
                { data: 'price_formatted', name: 'ecommerce_sales_details.price', className: 'text-right' },
                { data: 'gross', name: 'ecommerce_sales_details.price', className: 'text-right', orderable: false },
                { data: 'discount', name: 'ecommerce_sales_details.discount_amount', className: 'text-right' },
                { data: 'net_price', name: 'ecommerce_sales_details.price', className: 'text-right', orderable: false },
                { data: 'payment_method', name: 'ecommerce_sales_headers.payment_method' }, 
                { data: 'status_display', name: 'ecommerce_sales_headers.delivery_status', orderable: false }
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'csv',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'excel',
                    exportOptions: { columns: ':visible' }
                },
                {   
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        modifier: { page: 'current' }
                    },
                    orientation : 'landscape',
                    pageSize : 'LEGAL'
                },
                'colvis'
            ],
            pageLength: 20,
            order: [[0, 'desc']]
        });
    });
</script>
@endsection