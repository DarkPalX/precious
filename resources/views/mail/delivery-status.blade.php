<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Order Status Update</title>
    <style type="text/css">
        body { margin: 0; padding: 0; background-color: #FFFFFF; font-family: Arial, sans-serif; }
        .container { width: 850px; margin: 40px auto; background: #fff; padding: 40px; border: 1px solid #dddddd; border-radius: 5px; font-size: 14px; line-height: 1.6; color: #333333; }
        .logo { margin-bottom: 30px; }
        .content-text { font-size: 16px; color: #333333; }
        .status-box { font-weight: bold; margin: 25px 0; font-size: 16px; }
        .footer { margin-top: 40px; font-weight: bold; }
        ul { padding-left: 20px; margin-top: 5px; }
        li { margin-bottom: 5px; }
        .success-text { color: #28a745; font-weight: bold; }
        .danger-text { color: #dc3545; font-weight: bold; }
        .warning-box { background: #fff3f3; padding: 15px; border-left: 4px solid #dc3545; margin: 20px 0; }
    </style>
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <div class="container">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" class="logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('storage').'/logos/'.$setting->company_logo }}" alt="{{ $setting->company_name }}" width="175" />
                                </a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left" class="content-text">
                                <p>Dear <strong>{{ $h->user->firstname }}</strong>,</p>
                                <p>Good day!</p>
                                
                                {{-- 1. CONDITION FOR DELIVERED --}}
                                @if($h->delivery_status == 'Delivered')
                                    <p class="success-text">Great news! Your order <strong>(Invoice #{{ $h->order_number }})</strong> has been successfully delivered.</p>
                                    <p>We hope you enjoy your purchase! Thank you for choosing <strong>{{ $setting->company_name }}</strong>.</p>

                                {{-- 2. CONDITION FOR CANCELLED --}}
                                @elseif($h->delivery_status == 'Cancelled')
                                    <p>We are writing to inform you that your order <strong>(Invoice #{{ $h->order_number }})</strong> has been <span class="danger-text">CANCELLED</span>.</p>
                                    
                                    <div class="warning-box">
                                        <strong>Reason for Cancellation:</strong><br>
                                        {{ $h->cancellation_reason ?? 'No specific reason provided.' }}
                                    </div>
                                    <p>If you have already settled your payment and require a refund or have questions regarding this cancellation, please contact our support team immediately.</p>

                                {{-- 3. CONDITION FOR RETURNED --}}
                                @elseif($h->delivery_status == 'Returned')
                                    <p>This is to notify you that your order <strong>(Invoice #{{ $h->order_number }})</strong> has been marked as <span class="danger-text">RETURNED</span> to our warehouse.</p>
                                    
                                    <div class="warning-box">
                                        <strong>Status Detail:</strong> Returned to Sender<br>
                                        <strong>Remarks:</strong> {{ optional($h->deliveries->last())->remarks ?? 'Package was undeliverable or rejected.' }}
                                    </div>
                                    <p>Please reach out to us if you would like to arrange for a re-delivery (additional shipping fees may apply) or to process a manual pickup.</p>

                                {{-- 4. CONDITION FOR IN TRANSIT --}}
                                @elseif($h->delivery_status == 'In Transit')
                                    <p>We are pleased to inform you that your order <strong>(Invoice #{{ $h->order_number }})</strong> is now in transit. Please see the delivery details below:</p>
                                    
                                    <p style="margin-bottom: 0;"><strong>DOOR-TO-DOOR DELIVERY</strong></p>
                                    <ul>
                                        <li><strong>Metro Manila:</strong> Delivered via Champ Courier (2-3 days)</li>
                                        <li><strong>Outside Metro Manila:</strong> Delivered via Flash Express, J&amp;T Express and other couriers (5-7 days)</li>
                                    </ul>

                                    <p><strong>Note on Tracking:</strong> A tracking number will be provided by <strong>CHAMP COURIER</strong>.</p>

                                    <p style="margin-bottom: 0;"><strong>FOR PICK-UP ORDERS</strong></p>
                                    <ul>
                                        <li><strong>Address:</strong> G/F Jrich Corporate Center, 16 Sto. Domingo Ave. cor. P. Florentino St., Quezon City</li>
                                        <li><strong>Schedule:</strong> Monday to Friday, 10:00 AM &ndash; 5:00 PM</li>
                                    </ul>

                                {{-- 5. DEFAULT (PROCESSING / OTHERS) --}}
                                @else
                                    <p>Your order, <strong>Invoice #{{ $h->order_number }}</strong>, is now being processed and will be prepared for shipment shortly. We will notify you once it has been endorsed to our courier.</p>
                                    
                                    <div class="status-box">
                                        STATUS: {{ $h->delivery_status }}
                                    </div>
                                @endif

                                {{-- Universal Inquiry Text --}}
                                @if($h->delivery_status != 'Delivered')
                                <p>Should you have any inquiries, please feel free to contact us at 
                                    <strong>{{ $setting->mobile_no }} (Mobile)</strong>, 
                                    <strong>{{ $setting->tel_no }} (Landline)</strong>, 
                                    or via email at <strong>{{ $setting->email }}</strong>.
                                </p>
                                @endif

                                <p>Thank you!</p>
                            </td>
                        </tr>

                        <tr>
                            <td align="left" class="footer">
                                Regards,<br>
                                {{ $setting->company_name }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>