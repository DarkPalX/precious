<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

</head>
<title>Untitled Document</title>

<body>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f0f0;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p {
        margin: 10px 0;
        padding: 0;
        font-weight: normal;
    }

    p {
        font-size: 13px;
    }
</style>

<!-- BODY-->
<div style="max-width: 700px; width: 100%; background: #fff;margin: 30px auto;">

    <div style="padding:30px 60px;">
        <div style="text-align: center;padding: 20px 0;">            
            <img src="https://beta.ebooklat.phr.com.ph/storage/logos/1707185818_webfocus-logo.png" alt="company logo" width="175" />
        </div>

        <p>You will be missed!</p>

        <p>You have been unsubscribed from {{ config("app.CompanyName") }} mailing list.</p>
    </div>

    <div style="padding: 30px;background: #fff;margin-top: 20px;border-top: solid 1px #eee;text-align: center;color: #aaa;">
        <p style="font-size: 12px;">
            <br />
            <br />
           <strong>{{ config("app.CompanyName") }}</strong> <br /> {{config('app.CompanyAddress')}} <br /> {{config('app.CompanyTelephoneNo')}} | {{config('app.CompanyMobileNo')}}

            <br /><br /> {{ url('/') }}
        </p>
    </div>
</div>

</body>

</html>
