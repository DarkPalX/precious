<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EwalletPaymentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $h;
    public $setting;

    public function __construct($sales, $setting)
    {
        $this->h = $sales;
        $this->setting = $setting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->view('mail.ewallet-payment-status')
            ->subject('Order # '.$this->h->order_number.' has pending e-wallet payment.');
    }
}
