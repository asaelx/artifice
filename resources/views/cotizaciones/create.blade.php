@extends('layout.base')

@section('title', 'Cotizaciones')
@section('sectionTitle', 'Generar nueva cotización')

@section('content')
    <ul class="notifications">
    @foreach($errors->all() as $error)

      <li class="notification error">
        <div class="message"><span class="typcn typcn-warning"></span> {{ $error }}</div>
      </li>
    @endforeach

    </ul>
    <div class="row">
        <div class="col-12">
            {{ Form::model($estimate = new \App\Estimate, ['url' => 'cotizaciones', 'class' => 'form']) }}
                @include('cotizaciones.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection

@section('modal')
    @include('cotizaciones.modal')
@endsection
