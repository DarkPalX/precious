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
                        <img src="https://preciouspagesbookstore.com.ph/storage/logos/catha-email-logo.png" width="170" alt="Catha Logo">
                    </td>

                    <td style="border-left:2px solid #9b7ad1;padding-left:25px;color:#ffffff;">
                        <div style="font-size:30px;font-weight:bold;">
                            Password Reset
                        </div>

                        <div style="font-size:14px;color:#efe7f8;padding-top:8px;">
                            Your temporary password is ready.
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:40px 50px;font-size:14px;line-height:24px;color:#333333;">

            <p>Dear Customer,</p>

            <p>
                We received a request to reset your account password.
                For your security, a temporary password has been generated.
                Please use it to log in to your account, then change your password immediately.
            </p>

            <table align="center" cellpadding="0" cellspacing="0" style="margin:30px auto;">
                <tr>
                    <td style="border:2px dashed #7E57C2;background:#F4F0FA;padding:18px 40px;font-size:24px;color:#6F42C1;font-weight:bold;text-align:center;">
                        {{ $Password }}
                    </td>
                </tr>
            </table>

            <p>
                For your protection, please delete this email after successfully logging in and changing your password.
            </p>

            <p>
                If you did not request this password reset, please ignore this email or contact our support team immediately.
            </p>

            <br>

            <p>
                Thank you,<br>
                <strong>{{ config("app.CompanyName") }}</strong><br>
                Admin & Team Staff
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td bgcolor="#f5f6f6" style="padding:25px 40px;font-size:12px;color:#666666;line-height:20px;">

            This is a system generated email. Please do not reply.

            <br><br>

            <a href="https://preciouspagesbookstore.com.ph/privacy-policy">
                Privacy Policy
            </a>
            &nbsp;|&nbsp;

            <a href="https://preciouspagesbookstore.com.ph/terms-of-use-agreement">
                Terms &amp; Conditions
            </a>
            &nbsp;|&nbsp;

            <a href="#">
                Unsubscribe
            </a>

        </td>
    </tr>

</table>

</td>
</tr>
</table>