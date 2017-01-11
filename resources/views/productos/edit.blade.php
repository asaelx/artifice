@extends('layout.base')

@section('title', 'Productos')
@section('sectionTitle', 'Editar datos del producto')

@section('content')
    <div class="row">
        <div class="col-6">
            {{ Form::model($product, ['url' => url('productos', $product->id), 'files' => true, 'class' => 'form', 'method' => 'PATCH']) }}
                @include('productos.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
