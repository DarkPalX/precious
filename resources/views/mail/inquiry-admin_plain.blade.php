Dear {{ $adminInfo->firstname }},

{{ $clientInfo['name'] }} has sent an inquiry for your action.
Please see details of the inquiry below.

Subject: {{ $clientInfo['subject'] }}
Name: {{ $clientInfo['name'] }}
Email: {{ $clientInfo['email'] }}
Contact Number: {{ $clientInfo['contact'] }}
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
{{ $setting->company_address }}
{{ $setting->tel_no }} | {{ $setting->mobile_no }}

{{ url('/') }}
