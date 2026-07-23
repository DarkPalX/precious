
@php($ReferenceNo='')
@php($ModeOfPayment='')
@php($OrderDate='')

@php($FullName='')
@php($MobileNo='')
@php($EmailAddress='')

@php($Address='')

@php($EWalletPayment=0)
@php($DiscountAmount=0)

@php($SubTotal=0)
@php($GrandTotal=0)

@php($OrderInstruction='')

@if(isset($OrderInfo) > 0)
    @php($ReferenceNo=$OrderInfo->order_number)
    @php($ModeOfPayment=$OrderInfo->payment_method)
    @php($OrderDate=date_format(date_create($OrderInfo->order_date),'F d, Y H:i A'))

    @php($FullName=$OrderInfo->customer_name)

    @php($MobileNo=$OrderInfo->customer_contact_number)
    @php($EmailAddress=$OrderInfo->customer_email)

    @php($Address=$OrderInfo->customer_delivery_adress)

    @php($DiscountAmount=$OrderInfo->discount_amount)
    @php($EWalletPayment=$OrderInfo->ecredit_amount)
@endif

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#fafafa"><tr><td align="center">
<table role="presentation" width="960" style="max-width:960px;width:100%;margin:30px auto;background:#fff;border-radius:8px;border-collapse:collapse">

    <!-- HEADER -->
    <tr>
        <td bgcolor="#7E57C2" style="padding:30px 40px">
            <table width="100%"><tr>
                <td width="200"><img src="https://preciouspagesbookstore.com.ph/storage/logos/catha-email-logo.png" width="170"></td>
                <td style="border-left:2px solid #9b7ad1;padding-left:25px;color:#fff">
                    <div style="font-size:32px;font-weight:bold">Thank You For Your Order!</div>
                    <div style="font-size:14px;color:#efe7f8">We've received your order and it's on its way.</div>
                </td>
            </tr></table>
        </td>
    </tr>

    <!-- BODY -->
    <tr>
        <td style="padding:35px 40px">

            <p>Hi {{$FullName}}!</p>
            <p>Thank you for your order and you will find your order details below.</p>

            <!-- ORDER DETAILS -->
            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:20px">
                <tr>
                    <td width="60%" align="left" bgcolor="#7E57C2" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;color:#fff;"> {{$ReferenceNo}} </td>
                    <td width="40%" align="right" bgcolor="#7E57C2" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;color:#fff;"> {{$OrderDate}} </td>
                </tr>
                <tr>
                    <td width="60%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">{{$FullName}} </td>
                </tr>
                <tr>
                    <td width="60%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 50px 10px 0px 10px;"> {{$EmailAddress}} </td>
                </tr>
                <tr>
                    <td width="60%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> {{$MobileNo}}</td>
                </tr>
                <tr>
                    <td width="60%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 30px 10px 0px 10px;">  {{$Address}}</td>
                </tr>
            </table>

            <!-- ITEMS -->
            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:20px">
                <tr>
                    <td width="30%" align="left" bgcolor="#7E57C2" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;color:#fff;"> Product </td>

                    <td width="20%" align="center" bgcolor="#7E57C2" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;color:#fff;"> Unit Price </td>

                    <td width="20%" align="center" bgcolor="#7E57C2" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;color:#fff;"> Discounted Price </td>

                    <td width="10%" align="center" bgcolor="#7E57C2" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;color:#fff;"> Quantity </td>

                    <td width="20%" align="center" bgcolor="#7E57C2" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;color:#fff;"> Total </td>
                </tr>

                @foreach($OrderItem as $order_item)

                    @php($ProductName=$order_item->product_name)
                    @php($Qty=1)
                    @php($Price=$order_item->price)
                    @php($DiscountPrice=$order_item->discount_price)

                    @if($DiscountPrice>0)
                        @php($chkPrice=$DiscountPrice)
                        @php($ItemTotal=$DiscountPrice * $Qty)
                    @else
                        @php($chkPrice=$Price)
                        @php($ItemTotal=$Price * $Qty)
                    @endif

                    <tr style="border-bottom:1px solid #ddd">
                        <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">{{$ProductName}}</td>

                        <td width="20%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">₱{{number_format($Price,2)}}</td>

                        <td width="20%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">₱{{number_format($DiscountPrice,2)}}</td>

                        <td width="10%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">{{$Qty}}</td>

                        <td width="20%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">₱{{number_format($ItemTotal,2)}}</td>
                    </tr>

                    @php($SubTotal=$SubTotal + ($chkPrice * $Qty))
                @endforeach
            </table>

            <!-- SUBTOTAL -->
            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:20px">
                <tr>
                    <td colspan="3" width="75%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> SUBTOTAL: </td>
                    <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> ₱{{number_format($SubTotal,2)}} </td>
                </tr>

                @if($DiscountAmount > 0)
                <tr>
                    <td colspan="3" width="75%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> COUPON DISCOUNT: </td>
                    <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> -₱{{number_format($DiscountAmount,2)}} </td>
                </tr>
                @endif

                @if($EWalletPayment > 0)
                <tr>
                    <td colspan="3" width="75%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> E-WALLET: </td>
                    <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> -₱{{number_format($EWalletPayment,2)}} </td>
                </tr>
                @endif
                <tr>
                    <td colspan="3" width="75%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> GRAND TOTAL: </td>
                    <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> ₱{{number_format($SubTotal - $DiscountAmount - $EWalletPayment,2)}} </td>
                </tr>
            </table>

            <p style="margin-top:20px;color:#777777">You can also view your orders by logging in to your account <a href="https://beta.ebooklat.phr.com.ph" target="_blank">Login</a></p>

        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td bgcolor="#f5f6f6" style="padding:25px 40px;font-size:12px;color:#666">
            This is a system generated email. Please do not reply.<br><br>
            <a href="https://preciouspagesbookstore.com.ph/privacy-policy">Privacy Policy</a> |
            <a href="https://preciouspagesbookstore.com.ph/terms-of-use-agreement">Terms &amp; Conditions</a> |
            <a href="#">Unsubscribe</a>
        </td>
    </tr>

</table>
</td></tr></table>
