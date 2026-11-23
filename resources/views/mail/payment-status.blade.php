<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body style="background:#f5f6fa;font-family:Arial,sans-serif;margin:0;padding:20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:700px;margin:auto;background:#fff;border:1px solid #e5e5e5;">
        <tr>
            <td style="padding:20px;text-align:center;border-bottom:1px solid #eee;">
                <img src="{{ Setting::get_company_logo_storage_path() }}" alt="company logo" width="175">
            </td>
        </tr>
        <tr>
            <td style="padding:30px;color:#333;font-size:14px;line-height:1.6;">
                <h2>Payment Status Updated</h2>
                <p>Dear {{ optional($h->user)->firstname ?? $h->customer_name }},</p>
                <p>Your payment for order <strong>#{{ $h->order_number }}</strong> has been updated.</p>
                <p><strong>Payment Status:</strong> {{ $h->payment_status }}</p>
                <p><strong>Payment Method:</strong> {{ $h->payment_method }}</p>
                <p>If you have questions about this payment, please contact {{ $setting->email }}.</p>
                <p>Thank you,<br><strong>{{ $setting->company_name }}</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
