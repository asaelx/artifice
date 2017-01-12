@extends('layout.base')

@section('title', 'Cotizaciones')
@section('sectionTitle', 'Cotizaciones')
@section('add')
    <div class="buttons pr">
        <a href="{{ url('cotizaciones/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Nueva cotización</a>
    </div>
    <!-- /.buttons -->
@endsection

@section('content')
    @unless ($estimates->isEmpty())
        {{-- <div class="row">
            {{ Form::open(['url' => '/', 'class' => 'form']) }}
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('date', 'Fecha:', ['class' => 'label']) }}
                        {{ Form::input('text', 'date', null, ['class' => 'input']) }}
                    </div><!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('seller', 'Vendedor:', ['class' => 'label']) }}
                        {{ Form::select('seller', ['Vendedor', 'Vendedor', 'Vendedor'], null, ['class' => 'select2']) }}
                    </div><!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('status', 'Estado:', ['class' => 'label']) }}
                        {{ Form::select('seller', ['Pendiente', 'Aceptada', 'Rechazada'], null, ['class' => 'select2']) }}
                    </div><!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('company', 'Empresa:', ['class' => 'label']) }}
                        {{ Form::input('text', 'company', null, ['class' => 'input']) }}
                    </div><!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
            {{ Form::close() }}
        </div>
        <!-- /.row --> --}}
    @endunless
    <div class="row">
        <div class="col-12">
            @if ($estimates->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay cotizaciones</h2>
                    <!-- /.title -->
                    <a href="{{ url('cotizaciones/nuevo') }}" class="btn btn-blue">Generar una cotizacion</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Estado</th>
                            <th>Expira</th>
                            <th>Total</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estimates as $estimate)
                            <tr>
                                <td>{{ $estimate->folio }}</td>
                                <td>{{ ucfirst(\Date::createFromFormat('Y-m-d H:i:s', $estimate->created_at)->diffForHumans()) }}</td>
                                <td>{{ $estimate->client->name }}</td>
                                <td>{{ $estimate->user->name }}</td>
                                <td>
                                    @if ($estimate->status == 'Pendiente')
                                        <span class="badge badge-yellow">Pendiente</span>
                                    @elseif($estimate->status == 'Aceptada')
                                        <span class="badge badge-green">Aceptada</span>
                                    @elseif($estimate->status == 'Rechazada')
                                        <span class="badge badge-red">Rechazada</span>
                                    @endif
                                </td>
                                <td>{{ ucfirst(\Date::createFromFormat('Y-m-d', $estimate->expiration)->diffForHumans()) }}</td>
                                <td><span class="price">${{ $estimate->total }}</span></td>
                                <td>
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('cotizaciones/'.$estimate->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="{{ url('cotizaciones/'.$estimate->id.'/download') }}" class="link"><i class="typcn typcn-download"></i> Descargar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="{{ url('cotizaciones/'.$estimate->id.'/pdf') }}" class="link" target="_blank"><i class="typcn typcn-printer"></i> Imprimir</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="#" class="link modal-trigger" data-modal="send-mail" data-id="{{ $estimate->id }}"><i class="typcn typcn-mail"></i> Enviar correo</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('cotizaciones', $estimate->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
                                                    <button type="submit" class="link"><i class="typcn typcn-delete"></i> Eliminar</button>
                                                {{ Form::close() }}
                                            </li>
                                            <!-- /.item -->
                                        </ul>
                                        <!-- /.list -->
                                    </span><!-- /.dropdown -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- /.table -->
            @endif
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <div class="pagination">
                {{ $estimates->links() }}
            </div>
            <!-- /.pagination -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection

@section('modal')
    <div class="layer" id="send-mail-modal">
        <div class="modal">
            <h3 class="title"><i class="typcn typcn-mail"></i> Enviar Cotización por correo <button class="close-modal"><i class="typcn typcn-times"></i></button></h3>
            <!-- /.title -->
            <div class="content">
                {{ Form::open(['url' => url('cotizaciones/{id}/email'), 'class' => 'form']) }}
                    <div class="form-group">
                        {{ Form::label('email', 'Enviar a', ['class' => 'label']) }}
                        {{ Form::select('email', $emails, null, ['class' => 'select2-add', 'data-placeholder' => 'Selecciona o escribe un correo electrónico']) }}
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        {{ Form::label('subject', 'Asunto', ['class' => 'label']) }}
                        {{ Form::input('text', 'subject', 'Envío Cotización', ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        {{ Form::label('message', 'Mensaje', ['class' => 'label']) }}
                        {{ Form::textarea('message', null, ['size' => '30x5', 'class' => 'input autosizable']) }}
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        {{ Form::submit('Enviar', ['class' => 'btn btn-green']) }}
                    </div>
                    <!-- /.form-group -->
                {{ Form::close() }}
            </div>
            <!-- /.content -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- /.layer -->
@endsection
