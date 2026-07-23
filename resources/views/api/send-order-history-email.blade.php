<table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#fafafa"><tr><td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="margin:30px auto;border-radius:8px;">
<tr><td bgcolor="#7E57C2" style="padding:30px 40px;">
<table width="100%"><tr>
<td width="180"><img src="https://preciouspagesbookstore.com.ph/storage/logos/catha-email-logo.png" width="170"></td>
<td style="border-left:2px solid #9b7ad1;padding-left:25px;color:#fff;">
<div style="font-size:30px;font-weight:bold;">Purchase Order List</div>
<div style="font-size:14px;color:#efe7f8;padding-top:8px;">Thank you for your order.</div>
</td></tr></table></td></tr>
<tr><td style="padding:40px 50px;font-size:14px;line-height:24px;color:#333;">
@php($SubTotal=0)
<p>Hi {{$FullName}},</p>
<p>Thank you for all your orders! Below is a summary of your purchases.</p>
<table width="100%" cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse;">
<tr style="background:#7E57C2;color:#fff;"><th>Order No</th><th>Order Date</th><th>Product</th><th>Unit Price</th><th>Disc. Price</th><th>Qty</th></tr>
@foreach($OrderItemList as $order_item)
<tr>
<td>{{$order_item->order_number}}</td>
<td>{{$order_item->order_date_format}}</td>
<td>{{$order_item->product_name}}</td>
<td align="right">₱{{number_format($order_item->price,2)}}</td>
<td align="right">₱{{number_format($order_item->discount_price,2)}}</td>
<td align="center">1</td>
</tr>
@endforeach
</table>
<p>You can also view your orders by logging into your account.</p>
</td></tr>
<tr><td bgcolor="#f5f6f6" style="padding:25px 40px;font-size:12px;color:#666;line-height:20px;">
This is a system generated email. Please do not reply.<br><br>
<a href="https://preciouspagesbookstore.com.ph/privacy-policy">Privacy Policy</a> |
<a href="https://preciouspagesbookstore.com.ph/terms-of-use-agreement">Terms &amp; Conditions</a> |
<a href="#">Unsubscribe</a>
</td></tr></table></td></tr></table>