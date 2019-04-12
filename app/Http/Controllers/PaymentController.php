<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Auth;
use Dnetix\Redirection\PlacetoPay;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return("Hola voy a guardar el pago");
        $auth = new Auth();
        $reference = '123456';
        $placetopay = new PlacetoPay([
            'login' => env('P2P_ID'),
            'seed' => $auth->getSeed(),
            'nonce' => $auth->getNonce(),
            'tranKey' => $auth->getTranKey(),
            'url' => env('P2P_END_POINT')

        ]);

        $request = [
            'payment' => [
                'reference' => $reference,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'USD',
                    'total' => 120,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://p2p.app/payments/' . $reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        $response = $placetopay->request($request);


    }

    public function createRequest(Request $request)
    {
        $auth = new Auth();
        $reference = '123456';
        $placetopay = new PlacetoPay([
            'login' => env('P2P_ID'),
            'seed' => $auth->getSeed(),
            'nonce' => $auth->getNonce(),
            'tranKey' => $auth->getTranKey(),
            'url' => env('P2P_END_POINT')

        ]);

        $request = [
            'payment' => [
                'reference' => $reference,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'USD',
                    'total' => 120,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://p2p.app/payments/' . $reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        $response = $placetopay->request($request);
        dd($response);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
