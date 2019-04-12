@extends('template')

@section('title', 'Tienda Online')


@section('content')
    <div style="margin-top: 80px;">
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 60px;">Formulario de Compra</h1>
        <form class="form-horizontal" method="post" action="/payments/">
            <div class="form-group">
                <label for="total" class="col-sm-2 control-label">Total</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="total" placeholder="total" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="description" placeholder="Description" required>
                </div>
            </div>

            <div class="form-group">
                <label for="currencie" class="col-sm-2 control-label">Tipo de moneda</label>
                <div class="col-sm-10">
                    <select class="form-control" id="currencie" required>
                        <option>COP</option>
                        <option>USD</option>
                    </select>
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
@endsection
