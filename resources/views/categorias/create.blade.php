@extends('layout.base')

@section('title', 'Categorías')
@section('sectionTitle', 'Agregar nueva categoría')

@section('content')
    <div class="row">
        <div class="col-6">
            {{ Form::model($category = new \App\Category, ['url' => 'categorias', 'class' => 'form']) }}
                @include('categorias.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
