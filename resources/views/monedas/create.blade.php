@extends('layout.base')

@section('title', 'Monedas')
@section('sectionTitle', 'Agregar nueva moneda')

@section('content')
    <div class="row">
        <div class="col-6">
            {{ Form::model($currency = new \App\Currency, ['url' => 'monedas', 'class' => 'form']) }}
                @include('monedas.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
