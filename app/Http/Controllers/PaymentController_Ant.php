<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use App\Auth;

class PaymentControllerAnt extends Controller
{
    public function createRequest(Request $request)
    {
        #dd($request);
        $auth = new Auth();
        $client = new Client();
        $reference = '123456';
        $response = $client->request('POST', env('P2P_END_POINT'), [
            'json' => [
                'auth' => [
                    'login' => env('P2P_ID'),
                    'seed' => $auth->getSeed(),
                    'nonce' => $auth->getNonce(),
                    'tranKey' => $auth->getTranKey()
                ],

                'payment' => [
                    'reference' => $reference,
                    'description' => 'Ejemplo de pago',
                    'amount' => [
                        'currency' => 'COP',
                        'total' => '100000'
                    ]
                ],
                'expiration' => date('c', strtotime('+1 day')),
                'returnUrl' => 'pays/' . $reference,
                'ipAddress' => '127.0.0.1',
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063'
            ]
        ]);

    }
}
