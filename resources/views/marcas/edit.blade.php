@extends('layout.base')

@section('title', 'Marcas')
@section('sectionTitle', 'Editar datos de la marca')

@section('content')
    <div class="row">
        <div class="col-6">
            @include('layout.errors')
            {{ Form::model($brand, ['url' => url('marcas', $brand->id), 'class' => 'form', 'method' => 'PATCH']) }}
                @include('marcas.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
