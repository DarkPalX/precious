<!DOCTYPE html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Purchase Order</title></head>
<body style="margin:0;background:#fafafa;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#fafafa"><tr><td align="center">
<table role="presentation" width="960" style="max-width:960px;width:100%;margin:30px auto;background:#fff;border-radius:8px;border-collapse:collapse">
<tr><td bgcolor="#7E57C2" style="padding:30px 40px">
<table width="100%"><tr>
<td width="200"><img src="https://preciouspagesbookstore.com.ph/storage/logos/catha-email-logo.png" width="170"></td>
<td style="border-left:2px solid #9b7ad1;padding-left:25px;color:#fff">
<div style="font-size:32px;font-weight:bold">Purchase Order List</div>
<div style="font-size:14px;color:#efe7f8">Thank you for your orders.</div>
</td></tr></table></td></tr>
<tr><td style="padding:35px 40px">
<p>Hi {{$FullName}},</p>
<p>Thank you for all your orders! Below is a summary of your purchases.</p>
<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;font-size:14px">
<tr bgcolor="#7E57C2" style="color:#fff">
<th width="15%">Order No</th><th width="18%">Order Date</th><th width="35%" align="left">Product</th><th width="12%">Unit Price</th><th width="12%">Disc. Price</th><th width="8%">Qty</th>
</tr>
@foreach($OrderItemList as $order_item)
<tr style="border-bottom:1px solid #ddd">
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
<tr><td bgcolor="#f5f6f6" style="padding:25px 40px;font-size:12px;color:#666">
This is a system generated email. Please do not reply.<br><br>
<a href="https://preciouspagesbookstore.com.ph/privacy-policy">Privacy Policy</a> |
<a href="https://preciouspagesbookstore.com.ph/terms-of-use-agreement">Terms &amp; Conditions</a> |
<a href="#">Unsubscribe</a>
</td></tr></table></td></tr></table>
</body></html>