@extends('layout.base')

@section('title', 'Monedas')
@section('sectionTitle', 'Monedas')
@section('add')
    <a href="{{ url('monedas/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Agregar moneda</a>
@endsection

@section('content')
    @unless ($currencies->isEmpty())
        <div class="row">
            {{ Form::open(['url' => '/', 'class' => 'form']) }}
                <div class="col-6">
                    <div class="form-group">
                        {{ Form::label('title', 'Título', ['class' => 'label']) }}
                        {{ Form::input('text', 'title', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-6 -->
                <div class="col-6">
                    <div class="form-group">
                        {{ Form::label('code', 'Código', ['class' => 'label']) }}
                        {{ Form::input('text', 'code', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-6 -->
            {{ Form::close() }}
        </div>
        <!-- /.row -->
    @endunless
    <div class="row">
        <div class="col-12">
            @if ($currencies->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay monedas</h2>
                    <!-- /.title -->
                    <a href="{{ url('monedas/nuevo') }}" class="btn btn-blue">Agregar una moneda</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Código</th>
                            <th>Símbolo</th>
                            <th>Precisión</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currencies as $currency)
                            <tr>
                                <td>{{ $currency->title }}</td>
                                <td>{{ $currency->code }}</td>
                                <td>{{ $currency->symbol }}</td>
                                <td>{{ $currency->precision }}</td>
                                <td>
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('monedas/'.$currency->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('monedas', $currency->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
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
@endsection
