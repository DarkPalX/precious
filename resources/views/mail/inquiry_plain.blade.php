Dear {{ $clientInfo['name'] }},

This is to inform you that your inquiry has been sent to our Admin for action.
Please expect a response within 24 hours.

For your reference, please see details of your inquiry below.

Subject: {{ $clientInfo['subject'] }}
Name: {{ $clientInfo['name'] }}
Email: {{ $clientInfo['email'] }}
Contact Number: {{ $clientInfo['contact'] }}
Services: {{ $clientInfo['services'] }}
Message: {{ $clientInfo['message'] }}

@if(isset($clientInfo['company_address']))
Company Address: {{ $clientInfo['company_address'] }}
@endif

Services: 
@foreach($clientInfo['services'] as $key => $service)
    * {{ $service }}<br/>
@endforeach 


Regards,
{{ $setting->company_name }}



{{ $setting->company_name }}
{{ $setting->company_address }} {{ $setting->tel_no }} | {{ $setting->mobile_no }}

{{ url('/') }}
