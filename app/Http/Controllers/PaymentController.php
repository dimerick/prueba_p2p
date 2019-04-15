<?php

namespace App\Http\Controllers;

use App\Payment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Auth;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Auth as AuthUser;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;

class PaymentController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #\Alert::message('this is a test message', 'info');


        $userAuth = AuthUser::user();

        $payments = Payment::where('person', $userAuth->email)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        $currencies = DB::table('currencies')->get();

        $user = [
            'name' => $userAuth->name,
            'email' => $userAuth->email,
        ];


        return view('user-panel', [
            'user' => $user,
            'currencies' => $currencies,
            'payments' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    public function paymentResponse($id)
    {

        $payment = Payment::find($id);

        if ($payment == null) {
            \Alert::message('La transacción solicitada no es valida',
                'danger');
            return redirect('/');
        }

        $requestId = $payment->request_id;
        $dataPayment = $this->getDataPayment($requestId);


        $payment->payment_status = $dataPayment['estado'];
        $payment->payment_date = $dataPayment['fecha'];
        $payment->cus = $dataPayment['cus'];
        $payment->save();


        return view('payment-response', $dataPayment);

    }

    public function getDataPayment($requestId)
    {

        $placetopay = new PlacetoPay([
            'login' => env('P2P_ID'),
            'tranKey' => env('P2P_SECRET_KEY'),
            'url' => env('P2P_END_POINT')

        ]);

        $response = $placetopay->query($requestId);


        $razonSocial = 'Tienda Online';
        $nit = '123456789';
        $fecha = $response->payment()[0]->status()->date();
        $estado = $response->status()->status();
        $motivo = $response->payment()[0]->status()->reason() . ' - ' . $response->payment()[0]->status()->message();
        $valor = $response->payment()[0]->amount()->from()->currency() . ' ' . $response->payment()[0]->amount()->from()->total();
        $iva = $response->payment()[0]->amount()->from()->total() * .19;
        $franquicia = $response->payment()[0]->paymentMethodName();
        $banco = $response->payment()[0]->issuerName();
        $cus = $response->payment()[0]->authorization();
        $recibo = $response->payment()[0]->receipt();
        $referencia = $response->payment()[0]->reference();
        $descripcion = $response->request()->payment()->description();
        $ip = $response->request()->ipAddress();
        $cliente = $response->request()->payer()->name() . ' ' . $response->request()->payer()->surname();
        $email = $response->request()->payer()->email();
        $process_url = $response->request()->fields()[0]->value();

        $estado_desc = DB::table('payments_status')->where('cod', $estado)->get();

        $dataPayment = [
            'razonSocial' => $razonSocial,
            'nit' => $nit,
            'fecha' => $fecha,
            'estado_desc' => $estado_desc[0]->name,
            'motivo' => $motivo,
            'valor' => $valor,
            'iva' => $iva,
            'franquicia' => $franquicia,
            'banco' => $banco,
            'cus' => $cus,
            'recibo' => $recibo,
            'referencia' => $referencia,
            'descripcion' => $descripcion,
            'ip' => $ip,
            'cliente' => $cliente,
            'email' => $email,
            'process_url' => $process_url,
            'estado' => $estado
        ];

        return $dataPayment;
    }

    public function existenPagosPendientes($email)
    {
        $pendents = Payment::where('person', $email)->where('payment_status', 'PENDING')->get();

        return $pendents->count() > 0;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $userAuth = AuthUser::user();
        $email = $userAuth->email;

        if ($this->existenPagosPendientes($email)) {
            \Alert::message('En este momento presenta un proceso de pago cuya transacción 
            se encuentra pendiente de recibir confirmación por parte de su entidad financiera, 
            por favor espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa.',
                'danger');
            return back();
        }
        $total = $request->input('total');
        $currency = $request->input('currency');
        $description = $request->input('description');
        $expiration = date('c', strtotime('+1 day'));
        $ipAddress = request()->ip();
        $userAgent = $request->server('HTTP_USER_AGENT');


        //Saving object on database

        $payment = New Payment();
        $payment->description = $description;
        $payment->person = $email;
        $payment->total = $total;
        $payment->currency = $currency;
        $payment->expiration = $expiration;
        $payment->ip_address = $ipAddress;
        $payment->user_agent = $userAgent;

        $payment->save();


        $returnUrl = 'http://127.0.0.1:8000/payment-response/' . $payment->id;

        $placetopay = new PlacetoPay([
            'login' => env('P2P_ID'),
            'tranKey' => env('P2P_SECRET_KEY'),
            'url' => env('P2P_END_POINT')

        ]);

        $request = [
            'payment' => [
                'reference' => $payment->id,
                'description' => $description,
                'amount' => [
                    'currency' => $currency,
                    'total' => $total,
                ],
            ],
            'expiration' => $expiration,
            'returnUrl' => $returnUrl,
            'ipAddress' => $ipAddress,
            'userAgent' => $userAgent,
        ];

        $response = $placetopay->request($request);


        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl
            $payment->request_id = $response->requestId();
            $payment->process_url = $response->processUrl();
            $payment->save();
            return redirect()->away($response->processUrl());
        } else {
            // There was some error so check the message and log it

            \Alert::message($response->status()->message(), 'danger');
            return back();
        }


    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        if ($payment == null) {
            \Alert::message('La transacción solicitada no es valida',
                'danger');
            return redirect('/');
        }

        $requestId = $payment->request_id;
        $dataPayment = $this->getDataPayment($requestId);

        return view('payment-response', $dataPayment);
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
