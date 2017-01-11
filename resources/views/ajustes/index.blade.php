@extends('layout.base')

@section('title', 'Ajustes')
@section('sectionTitle', 'Ajustes')

@section('content')
    <div class="row">
        <div class="col-6">
            {{ Form::model($setting, ['url' => url('ajustes', $setting->id), 'class' => 'form', 'files' => true, 'method' => 'PATCH']) }}
                @include('ajustes.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
