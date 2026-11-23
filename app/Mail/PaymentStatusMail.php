<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $h;
    public $setting;

    public function __construct($sales, $setting)
    {
        $this->h = $sales;
        $this->setting = $setting;
    }

    public function build()
    {
        return $this->view('mail.payment-status')
            ->subject('Payment for order #'.$this->h->order_number.' has been updated.');
    }
}
