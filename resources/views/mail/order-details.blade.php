<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; font-family: 'Open Sans', Helvetica, Arial, sans-serif; background-color: #eeeeee; }
        
        .payment-banner {
            background-color: #1a3a5d; 
            color: #ffffff;
            border-radius: 4px;
            padding: 25px;
        }

        .order-table th {
            background-color: #3E91F6;
            color: #ffffff;
            padding: 10px;
            font-weight: 800;
        }

        .order-table td {
            padding: 10px;
            border-bottom: 1px solid #eeeeee;
        }
    </style>
</head>

<body style="margin: 0 !important; padding: 0 !important;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:800px; background-color: #ffffff;">
                    <tr>
                        <td align="left" style="padding: 40px;">
                            <h1 style="font-size: 26px; font-weight: 800; margin: 0 0 20px 0; color: #333333;">Order Confirmation!</h1>
                            <p style="font-size: 16px; color: #555555; line-height: 24px;">Hi <strong>{{$h->customer_name}}</strong>!</p>
                            <p style="font-size: 16px; color: #555555; line-height: 24px;">
                                Thank you for shopping with <strong>Precious Pages Bookstore</strong>. Please find your order details below, along with instructions for settling your payment via our various payment methods.
                            </p>

                            <table width="100%" cellpadding="10" cellspacing="0" style="background-color: #000000; color: #ffffff; margin-top: 20px;">
                                <tr>
                                    <td align="left" style="font-weight: 800;">Order #{{$h->order_number}}</td>
                                    <td align="right" style="font-weight: 800;">{{date('F d, Y', strtotime($h->created_at))}}</td>
                                </tr>
                            </table>

                            <table class="order-table" width="100%" cellpadding="0" cellspacing="0" style="margin-top: 10px; font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th align="left" width="40%">Product</th>
                                        <th align="center">Price</th>
                                        <th align="center">Qty</th>
                                        <th align="right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $subtotal = 0; @endphp
                                    @foreach($h->items as $i)
                                    @php $subtotal += $i->price * $i->qty; @endphp
                                    <tr>
                                        <td align="left" style="color: #333333;">{{$i->product_name}}</td>
                                        <td align="center">₱{{number_format($i->price, 2)}}</td>
                                        <td align="center">{{$i->qty}}</td>
                                        <td align="right" style="font-weight: bold;">₱{{number_format(($i->price * $i->qty), 2)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table width="100%" cellpadding="5" cellspacing="0" style="margin-top: 10px; font-size: 15px;">
                                <tr>
                                    <td align="right" style="font-weight: 800; border-top: 2px solid #eeeeee; padding-top: 10px;">SUBTOTAL:</td>
                                    <td align="right" width="25%" style="font-weight: 800; border-top: 2px solid #eeeeee; padding-top: 10px;">₱{{number_format($subtotal, 2)}}</td>
                                </tr>
                                <tr>
                                    <td align="right" style="color: #777777;">DELIVERY FEE:</td>
                                    <td align="right" style="color: #777777;">₱{{number_format($h->delivery_fee_amount, 2)}}</td>
                                </tr>
                                @if($h->discount_amount > 0)
                                <tr>
                                    <td align="right" style="color: #ff0000;">DISCOUNT:</td>
                                    <td align="right" style="color: #ff0000;">-₱{{number_format($h->discount_amount, 2)}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td align="right" style="font-size: 18px; font-weight: 800; color: #333333;">GRAND TOTAL:</td>
                                    <td align="right" style="font-size: 18px; font-weight: 800; color: #333333;">₱{{number_format($subtotal - $h->discount_amount + $h->delivery_fee_amount, 2)}}</td>
                                </tr>
                            </table>

                            <div style="margin-top: 40px; border-top: 1px solid #dddddd; padding-top: 20px;">
                                <h3 style="margin: 0 0 10px 0; color: #333333;">Payment Instructions:</h3>
                                
                                <p style="margin: 0; font-weight: bold; font-size: 15px;">For COD (Cash on Delivery):</p>
                                <p style="margin: 5px 0 15px 0; color: #555555;">Pay with cash when the courier delivers your order.<br>
                                <span style="color: #ff0000; font-style: italic; font-size: 13px;">Note: COD is available only within Metro Manila and selected areas.</span></p>

                                <p style="margin: 20px 0 5px 0; font-weight: bold; font-size: 15px;">For NON-COD:</p>
                                <p style="margin: 0 0 25px 0; color: #555555; line-height: 22px;">
                                    Please settle your payment using any of the methods listed below. Once completed, take a screenshot of your successful transaction or receipt and email it to <strong style="color: #333333;">preciouspayment@gmail.com</strong>. Please include your <strong>Full Name</strong> and <strong>Order Invoice Number</strong> for verification.
                                </p>
                            </div>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="payment-banner">
                                <tr>
                                    <td width="55%" valign="top" style="padding-right: 20px; border-right: 1px solid rgba(255,255,255,0.2);">
                                        <h2 style="font-size: 20px; margin: 0 0 15px 0; letter-spacing: 2px; text-align: center; color: #ffffff; font-family: sans-serif;">BANK</h2>
                                        
                                        <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 20px; margin-left: 20px;">
                                            <tr>
                                                <td width="50" valign="middle">
                                                    <img src="https://play-lh.googleusercontent.com/UblHlJXPdYZjXR9jJgkbVdKYQX2iLBGbFvbcITooYpg89d-_QBD5o_wfPtpJeo0Br6g=w240-h480-rw" width="45" style="border-radius: 4px; background: white; padding: 2px; display: block;">
                                                </td>
                                                <td style="font-size: 12px; color: #ffffff; line-height: 16px; padding-left: 10px; font-family: sans-serif;">
                                                    Acct. Name: Precious Pages Corporation<br>
                                                    Account No.: 0064 2000 1187
                                                </td>
                                            </tr>
                                        </table>

                                        <table border="0" cellpadding="0" cellspacing="0" style="margin-left: 20px;">
                                            <tr>
                                                <td width="50" valign="middle">
                                                    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQ8sURHYDshjhBfNJkE-mWMnV3U7n256pfSwiHCjTcuxQ1pvDpG" width="45" style="border-radius: 4px; background: white; padding: 2px; display: block;">
                                                </td>
                                                <td style="font-size: 12px; color: #ffffff; line-height: 16px; padding-left: 10px; font-family: sans-serif;">
                                                    Acct. Name: JRICH HOLDINGs<br>
                                                    Account No.: 324 320 8121
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td width="45%" valign="top" style="padding-left: 20px;">
                                        <h2 style="font-size: 20px; margin: 0 0 15px 0; letter-spacing: 2px; text-align: center;">E-WALLET</h2>
                                        <div align="center">
                                            <img src="https://img.utdstc.com/icon/711/4cb/7114cb1d21a6384a13ea739687e23c1faa7c131954b8d39d6da308cde9cdc04c:200" width="50" style="background: white; border-radius: 4px; padding: 5px; margin: 0 5px;">
                                            <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRyy8v3V7-y007pb8gxyd6qESCGq4NG0iBb-vQrBpG6xMoylS3h" width="50" style="background: white; border-radius: 4px; padding: 5px; margin: 0 5px;">
                                        </div>
                                        <p style="font-size: 12px; color: #ffffff; text-align: center; margin-top: 15px; line-height: 18px;">
                                            Account. Name: Segundo Matias<br>
                                            Account No.: 0969 216 0533
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="font-size: 13px; color: #999999; text-align: center; margin-top: 30px;">
                                You can also view your orders by logging in to your account at {{ url('/') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>