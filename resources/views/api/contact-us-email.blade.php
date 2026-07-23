<table role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#fafafa">
<tr>
<td align="center">

<table role="presentation" width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="margin:30px auto;border-radius:8px;">

    <!-- Header -->
    <tr>
        <td bgcolor="#7E57C2" style="padding:30px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>

                    <td width="180">
                        <img src="https://preciouspagesbookstore.com.ph/storage/logos/catha-email-logo.png" width="170">
                    </td>

                    <td style="border-left:2px solid #9b7ad1;padding-left:25px;color:#ffffff;">
                        <div style="font-size:30px;font-weight:bold;">
                            Contact Inquiry
                        </div>

                        <div style="font-size:14px;color:#efe7f8;padding-top:8px;">
                            A new inquiry has been submitted from your website & app.
                        </div>
                    </td>

                </tr>
            </table>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:40px 50px;font-size:14px;line-height:24px;color:#333333;">

            <p>Dear Admin,</p>

            <p>
                You have received a new contact inquiry. Below are the details submitted by the customer.
            </p>

            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;margin-top:20px;">

                <tr>
                    <td width="150" style="font-weight:bold;background:#F8F5FD;border:1px solid #E5DDF4;">
                        Full Name
                    </td>
                    <td style="border:1px solid #E5DDF4;color:#6F42C1;">
                        <strong>{{ $FullName }}</strong>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight:bold;background:#F8F5FD;border:1px solid #E5DDF4;">
                        Contact No.
                    </td>
                    <td style="border:1px solid #E5DDF4;color:#6F42C1;">
                        <strong>{{ $MobileNo }}</strong>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight:bold;background:#F8F5FD;border:1px solid #E5DDF4;">
                        Email Address
                    </td>
                    <td style="border:1px solid #E5DDF4;color:#6F42C1;">
                        <strong>{{ $EmailAddress }}</strong>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight:bold;background:#F8F5FD;border:1px solid #E5DDF4;">
                        Subject
                    </td>
                    <td style="border:1px solid #E5DDF4;color:#6F42C1;">
                        <strong>{{ $Subject }}</strong>
                    </td>
                </tr>

            </table>

            <p style="margin-top:30px;margin-bottom:10px;font-weight:bold;">
                Message
            </p>

            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="border:2px dashed #7E57C2;background:#F4F0FA;padding:20px;color:#6F42C1;">
                        {{ $Message }}
                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td bgcolor="#f5f6f6" style="padding:25px 40px;font-size:12px;color:#666666;line-height:20px;">

            This is a system generated email. Please do not reply.

            <br><br>

            <a href="https://preciouspagesbookstore.com.ph/privacy-policy">
                Privacy Policy
            </a> |

            <a href="https://preciouspagesbookstore.com.ph/terms-of-use-agreement">
                Terms &amp; Conditions
            </a> |

            <a href="#">
                Unsubscribe
            </a>

        </td>
    </tr>

</table>

</td>
</tr>
</table>