
@foreach($payments as $payment)
    <tr>
        <td>{{$payment->receipt_number}}</td>
        <td>{{$payment->payment_date}}</td>
        <td>{{$payment->payment_type}}</td>
        <td>{{$payment->status}}</td>
        <td class="text-right">{{number_format($payment->amount,2)}}</td>
    </tr>
@endforeach
<tr style="font-weight:bold;">
	<td colspan="4">Total</td>
	<td class="text-right">{{number_format($payments->sum('amount'),2)}}</td>
</tr>