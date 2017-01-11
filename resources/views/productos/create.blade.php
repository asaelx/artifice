@extends('layout.base')

@section('title', 'Productos')
@section('sectionTitle', 'Agregar nuevo producto')

@section('content')
    <div class="row">
        <div class="col-6">
            {{ Form::model($product = new \App\Product, ['url' => 'productos', 'files' => true, 'class' => 'form']) }}
                @include('productos.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
