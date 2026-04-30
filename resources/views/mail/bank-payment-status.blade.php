<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body style="background:#f5f6fa; font-family: Arial, sans-serif; margin:0; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:700px; margin:auto; background:#ffffff; border-radius:8px; overflow:hidden; border:1px solid #e5e5e5;">

        {{-- HEADER --}}
        <tr>
            <td style="padding:20px; text-align:center; border-bottom:1px solid #eee;">
                <img src="{{ Setting::get_company_logo_storage_path() }}" alt="company logo" width="175" />
            </td>
        </tr>

        {{-- BODY --}}
        <tr>
            <td style="padding:30px; color:#333; font-size:14px; line-height:1.6;">

                <h2 style="margin-top:0;">Bank Payment Instructions</h2>

                <p>
                    Dear {{ $h->user->firstname }},
                </p>

                <p>
                    Thank you for your order <strong>#{{ $h->order_number }}</strong>.
                </p>

                <p>
                    Please complete your payment via bank transfer using the details below:
                </p>

                {{-- BANK DETAILS BOX --}}
                <table width="100%" style="background:#f8f9fa; border:1px solid #ddd; border-radius:5px; margin:20px 0;">
                    <tr>
                        <td style="padding:15px;">
                            <strong>Bank Details</strong><br><br>
                            Bank Name: <strong>BDO Unibank</strong><br>
                            Account Name: <strong>{{ $setting->bdo_account_name }}</strong><br>
                            Account Number: <strong>{{ $setting->bdo_account_number }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:15px;">
                            Bank Name: <strong>BPI</strong><br>
                            Account Name: <strong>{{ $setting->bpi_account_name }}</strong><br>
                            Account Number: <strong>{{ $setting->bpi_account_number }}</strong>
                        </td>
                    </tr>
                </table>

                <p>
                    After sending the payment, please email us the following:
                </p>

                {{-- LIST --}}
                <ul style="padding-left:20px;">
                    <li>Your Name</li>
                    <li>Order Number (#{{ $h->order_number }})</li>
                    <li>Bank Used</li>
                    <li>Reference Number</li>
                    <li><strong>Screenshot / Proof of Transfer</strong></li>
                </ul>

                <p>
                    Send your confirmation to:
                </p>

                {{-- EMAIL BOX --}}
                <p style="background:#eef2ff; padding:10px; border-radius:5px;">
                    <strong>{{ $setting->payment_email }}</strong>
                </p>

                <p>
                    Once verified, we will process your order and notify you.
                </p>

                <br>

                <p>
                    Regards,<br>
                    <strong>{{ $setting->company_name }}</strong>
                </p>

            </td>
        </tr>

        {{-- FOOTER --}}
        <tr>
            <td style="padding:15px; text-align:center; font-size:12px; color:#999; border-top:1px solid #eee;">
                © {{ date('Y') }} {{ $setting->company_name }}. All rights reserved.
            </td>
        </tr>

    </table>

</body>
</html>