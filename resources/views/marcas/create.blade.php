@extends('layout.base')

@section('title', 'Marcas')
@section('sectionTitle', 'Agregar nueva marca')

@section('content')
    <div class="row">
        <div class="col-6">
            {{ Form::model($brand = new \App\Brand, ['url' => 'marcas', 'class' => 'form']) }}
                @include('marcas.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
