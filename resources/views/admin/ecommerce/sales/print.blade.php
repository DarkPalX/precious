@extends('admin.layouts.app')

@section('pagecss')
    <style>
        .table td {
            padding: 10px;
            font-size: 13px;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            #printable, #printable * {
                visibility: visible;
            }
            #printable {
                position: relative; /* Change position to relative */
                margin: 0 auto; /* Center horizontally */
                top: 35px; /* Adjust top position as needed */
            }
        }
    </style>
@endsection

@section('content')
    <div class=" pd-x-0" id="printable">
        
        <div class="row align-items-center justify-content-center mb-5">
            <div class="col-sm-5 col-lg-3 text-center">
                <div class="mg-b-20">
                    <img height="100px" width="90%" src="{{ asset('storage/logos/'.Setting::info()->company_logo) }}" alt="">
                    <p class="mb-0">{{ Setting::info()->company_address }}</p>
                </div>
            </div>
        </div>
    
        <h4 class="mg-b-0 tx-spacing--1 tx-center"> Sales Transaction Summary</h4>
        <h5 class="mg-b-0 tx-spacing--1 tx-center">Invoice# : {{$sales->order_number}}</h5>
        <div class="row row-sm mg-b-10">

            <div class="col-sm-6 col-lg-6 mg-t-20">
                <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Customer Details</label>
                <p class="mg-b-3 tx-semibold">{{$sales->customer_name}}</p>
                <p class="mg-b-3">{{$sales->customer_details->email}}</p>
                <p class="mg-b-20">Mobile No: {{$sales->customer_contact_number}}</p>

                <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Order Details</label>
                <p class="mg-b-3">Invoice No.: {{$sales->order_number}}</p>
                <p class="mg-b-3">Order Date: {{ date('F d, Y', strtotime($sales->created_at))}}</p>
                <p class="mg-b-3">Delivery Type: {{ strtoupper($sales->delivery_type) }}</p>
                @if($sales->cancellation_request === 1)
                    <p class="mg-b-3">Cancellation Reason: <span class="tx-success tx-semibold">{{$sales->cancellation_reason}}</span></p>
                    <p class="mg-b-3">Cancellation Remark: <span class="tx-success tx-semibold">{{$sales->cancellation_remarks}}</span></p>
                @endif

            </div>
            <div class="col-sm-6 col-lg-6 mg-t-20">
                <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Payment and Delivery Details</label>
                <p class="mg-b-3">Order Status: <span class="tx-success tx-semibold">{{$status}}</span></p>
                <p class="mg-b-3">Delivery Status: <span class="tx-success tx-semibold tx-uppercase">{{$sales->delivery_status}}</span></p>
                
                <p class="mg-b-3 mg-t-20">Delivery Address: {{$sales->customer_delivery_adress}}</p>
                <p class="mg-b-3 mg-t-10">Notes: {{$sales->other_instruction}}</p>
            </div>
        
        </div>

        <div class="row row-sm">
            <table class="table table-bordered mg-b-10">
                <thead style="background-color:#000000;">
                    <tr>
                        <th class="text-white wd-30p">Item</th>
                        <th class="text-white tx-center">Quantity</th>
                        <th class="text-white tx-center">Original Price</th>
                        <th class="text-white tx-center">Discounted Price</th>
                        <th class="text-white tx-center">Discount</th>
                        <th class="text-white tx-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $gross = 0; $discount = 0; $subtotal = 0; @endphp
                    @forelse($salesDetails as $details)
    
                    @php
                    $discount = \App\Models\Ecommerce\CouponSale::total_product_discount($sales->id,$details->product_id,$details->qty,$details->price);
                    $product_subtotal = $details->price*$details->qty;
    
                    $subtotal += $product_subtotal;
                    @endphp
                    <tr class="pd-20">
                        <td class="tx-nowrap">{{$details->product_name}}</td>
                        <td class="tx-right">{{number_format($details->qty, 0)}}</td>
                        <td class="tx-right">{{number_format($details->product->price ?? $details->price, 2)}}</td>
                        <td class="tx-right">{{number_format($details->product->discount_price ?? 0, 2)}}</td>
                        <td class="tx-right">{{number_format($details->discount_amount, 2)}}</td>
                        <td class="tx-right">{{number_format($product_subtotal, 2)}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="tx-center" colspan="6">No transaction found.</td>
                    </tr>
                    @endforelse
    
                    @php
                    $delivery_discount = \App\Models\Ecommerce\CouponSale::total_discount_delivery($sales->id);
                    $net_amount = ($subtotal-$sales->discount_amount)+($sales->delivery_fee_amount-$delivery_discount);
                    @endphp
    
                    <tr>
                        <td  class="tx-right" colspan="5"><strong>Subtotal:</strong></td>
                        <td class="tx-right"><strong>{{number_format($subtotal, 2)}}</strong></td>
                    </tr>
    
                    @if($sales->discount_amount > 0)
                    <tr>
                        <td  class="tx-right" colspan="5"><strong>Coupon Discount:</strong></td>
                        <td class="tx-right"><strong>{{number_format($sales->discount_amount, 2)}}</strong></td>
                    </tr>
                    <tr>
                        <td  class="tx-right border-0" colspan="5">
                            <strong>Coupons:</strong>
                        </td>
                        <td  class="tx-right border-0">
                            @foreach($sales->coupons as $couponSale)
                                <span class="badge badge-light p-2" style="font-size: 14px;">{{ $couponSale->details->name }}</span><br>
                            @endforeach                    
                        </td>
                    </tr>
                    @endif
    
                    {{-- @if($sales->delivery_fee_amount > 0) --}}
                    <tr>
                        <td  class="tx-right" colspan="5"><strong>Delivery Fee:</strong></td>
                        <td class="tx-right"><strong>{{number_format($sales->delivery_fee_amount, 2)}}</strong></td>
                    </tr>
                    {{-- @endif --}}
    
                    @if($delivery_discount > 0)
                    <tr>
                        <td  class="tx-right" colspan="5"><strong>Delivery Discount:</strong></td>
                        <td class="tx-right"><strong>{{number_format($delivery_discount, 2)}}</strong></td>
                    </tr>
                    @endif
    
                    <tr>
                        <td  class="tx-right" colspan="5"><strong>Grand Total:</strong></td>
                        <td class="tx-right"><strong>{{ number_format(($sales->product_id != 0 ? $sales->net_amount + $sales->ecredit_amount : $sales->net_amount), 2) }}</strong></td>
                        {{-- <td class="tx-right"><strong>{{ number_format($sales->net_amount, 2) }}</strong></td> --}}
                    </tr>
    
                    @if($sales->ecredit_amount > 0)
                    <tr>
                        <td  class="tx-right" colspan="5"><strong>E-Wallet Payment:</strong></td>
                        <td class="tx-right"><strong>{{number_format($sales->ecredit_amount, 2)}}</strong></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('pagejs')

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
    
@endsection

