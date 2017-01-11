@extends('layout.base')

@section('title', 'Usuarios')
@section('sectionTitle', 'Agregar nuevo usuario')

@section('content')
    <div class="row">
        <div class="col-6">
            {{ Form::model($user = new \App\User, ['url' => 'usuarios', 'class' => 'form']) }}
                @include('usuarios.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
