@extends('layouts.app')

@section('content')
    <div class="user-panel">

        <div class="container-fluid">
            {!! Alert::render() !!}
            <div class="row">


                <div class="col-sm-6">

                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Formulario de Compra</strong></div>
                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/payments">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="{{$user['name']}}" disabled>
                                    </div>
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="{{$user['email']}}" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="total" class="col-sm-2 control-label">Total</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" id="total" name="total"
                                               placeholder="total" min="1"
                                               value="0" step="any" required>
                                    </div>
                                    <label for="currency" class="col-sm-2 control-label">Tipo de moneda</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="currency" id="currency" required>
                                            @foreach($currencies as $c)
                                                <option value="{{$c->cod}}">{{$c->cod}}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description"
                                               placeholder="Descripción" required>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-default">Iniciar Pago</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

                <div class="col-sm-6">

                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Ultimas Transacciones</strong></div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <th>Fecha y hora</th>
                                    <th>Referencia</th>
                                    <th>Autorizacion/CUS</th>
                                    <th>Estado</th>
                                    <th>Valor</th>
                                </tr>
                                @foreach($payments as $p)
                                    @if($p->payment_status == 'REJECTED')
                                        <tr class="danger">
                                    @elseif($p->payment_status == 'PENDING')
                                        <tr>
                                    @elseif($p->payment_status == 'APPROVED')
                                        <tr class="success">
                                    @else
                                        <tr>
                                            @endif

                                            <td>{{$p->payment_date}}</td>
                                            <td><a href="/payments/{{$p->id}}">REF-{{$p->id}}</a></td>
                                            <td>{{$p->cus}}</td>
                                            <td>{{$p->payment_status}}</td>
                                            <td>{{$p->currency}} {{$p->total}}</td>
                                        </tr>
                                        @endforeach
                            </table>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>
@endsection
