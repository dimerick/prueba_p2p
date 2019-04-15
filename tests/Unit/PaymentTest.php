<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Payment;

class PaymentTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testSavePayment(){
        $description = 'Testing payment';
        $person = 'ericksaenz@outlook.com';
        $total = 523100;
        $currency = 'USD';
        $expiration = date('c', strtotime('+1 day'));
        $ipAddress = '127.0.0.1';
        $userAgent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36';


        $payment = New Payment();
        $payment->description = $description;
        $payment->person = $person;
        $payment->total = $total;
        $payment->currency = $currency;
        $payment->expiration = $expiration;
        $payment->ip_address = $ipAddress;
        $payment->user_agent = $userAgent;

        $payment->save();

        $paymentSaved = Payment::find($payment->id);

        $this->assertEquals($paymentSaved->id, $payment->id);
        $this->assertEquals($paymentSaved->description, $payment->description);
        $this->assertEquals($paymentSaved->person, $payment->person);
        $this->assertEquals($paymentSaved->total, $payment->total);
        $this->assertEquals($paymentSaved->currency, $payment->currency);
        $this->assertEquals($paymentSaved->expiration, $payment->expiration);
        $this->assertEquals($paymentSaved->ip_address, $payment->ip_address);
        $this->assertEquals($paymentSaved->user_agent, $payment->user_agent);

    }


}
