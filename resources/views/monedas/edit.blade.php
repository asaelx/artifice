@extends('layout.base')

@section('title', 'Monedas')
@section('sectionTitle', 'Editar datos de la moneda')

@section('content')
    <div class="row">
        <div class="col-6">
            {{ Form::model($currency, ['url' => url('marcas', $currency->id), 'class' => 'form', 'method' => 'PATCH']) }}
                @include('monedas.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
