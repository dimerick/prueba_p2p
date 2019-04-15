@extends('layouts.app')

@section('content')
    <div class="user-panel">

        <div class="container">
            {!! Alert::render() !!}
            <div class="payment-response">
                <table class="table table-bordered">
                    <tr>
                        <th>Label</th>
                        <th>Información</th>
                    </tr>
                    <tr>
                        <th>Razón Social</th>
                        <td>{{$razonSocial}}</td>
                    </tr>
                    <tr>
                        <th>NIT</th>
                        <td>{{$nit}}</td>
                    </tr>
                    <tr>
                        <th>Fecha y Hora</th>
                        <td>{{$fecha}}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>{{$estado_desc}}</td>
                    </tr>
                    <tr>
                        <th>Motivo</th>
                        <td>{{$motivo}}</td>
                    </tr>
                    <tr>
                        <th>Valor</th>
                        <td>{{$valor}}</td>
                    </tr>
                    <tr>
                        <th>IVA</th>
                        <td>{{$iva}}</td>
                    </tr>
                    <tr>
                        <th>Franquicia</th>
                        <td>{{$franquicia}}</td>
                    </tr>
                    <tr>
                        <th>Banco</th>
                        <td>{{$banco}}</td>
                    </tr>
                    <tr>
                        <th>Autorización / CUS</th>
                        <td>{{$cus}}</td>
                    </tr>
                    <tr>
                        <th>Recibo</th>
                        <td>{{$recibo}}</td>
                    </tr>
                    <tr>
                        <th>Referencia</th>
                        <td>{{$referencia}}</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>{{$descripcion}}</td>
                    </tr>
                    <tr>
                        <th>Dirección IP</th>
                        <td>{{$ip}}</td>
                    </tr>
                    <tr>
                        <th>Cliente</th>
                        <td>{{$cliente}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$email}}</td>
                    </tr>
                </table>

                <a href="#" onclick="window.print();" class="btn btn-success btn-lg active" role="button">Imprimir</a>
                @if($estado == 'APPROVED')
                    <a href="/" class="btn btn-success btn-lg active" role="button">Volver a inicio</a>
                @elseif($estado == 'PENDING')
                    <a href="/" class="btn btn-success btn-lg active" role="button">Volver a inicio</a>
                @elseif($estado == 'REJECTED')
                    <a href="{{$process_url}}" class="btn btn-success btn-lg active" role="button">Reintentar</a>
                @elseif($estado == 'FAILED')
                    <a href="{{$process_url}}" class="btn btn-success btn-lg active" role="button">Reintentar</a>
                @endif
            </div>

        </div>
    </div>
@endsection
