@extends('layout.base')

@section('title', 'Categorías')
@section('sectionTitle', 'Editar datos de la categoría')

@section('content')
    <div class="row">
        <div class="col-6">
            @include('layout.errors')
            {{ Form::model($category, ['url' => url('categorias', $category->id), 'class' => 'form', 'method' => 'PATCH']) }}
                @include('categorias.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
