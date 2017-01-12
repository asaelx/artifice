@extends('layout.base')

@section('title', 'Clientes')
@section('sectionTitle', 'Clientes')
@section('add')
    <a href="{{ url('clientes/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Nuevo cliente</a>
@endsection

@section('content')
    @unless ($clients->isEmpty())
        <div class="row">
            {{ Form::open(['url' => '/', 'class' => 'form']) }}
                <div class="col-4">
                    <div class="form-group">
                        {{ Form::label('name', 'Nombre', ['class' => 'label']) }}
                        {{ Form::input('text', 'name', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-4 -->
                <div class="col-4">
                    <div class="form-group">
                        {{ Form::label('email', 'Correo electrónico', ['class' => 'label']) }}
                        {{ Form::input('text', 'email', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-4 -->
                <div class="col-4">
                    <div class="form-group">
                        {{ Form::label('phone', 'Teléfono', ['class' => 'label']) }}
                        {{ Form::input('text', 'phone', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-4 -->
            {{ Form::close() }}
        </div>
        <!-- /.row -->
    @endunless
    <div class="row">
        <div class="col-12">
            @if ($clients->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay clientes</h2>
                    <!-- /.title -->
                    <a href="{{ url('clientes/nuevo') }}" class="btn btn-blue">Agregar un cliente</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th>Teléfono</th>
                            <th>Fecha de registro</th>
                            <th>Cotizaciones</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td><a href="mailto:{{ $client->email }}" class="link">{{ $client->email }}</a></td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->created_at }}</td>
                                <td><a href="#" class="link">3</a></td>
                                <td>
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('clientes/'.$client->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="#" class="link"><i class="typcn typcn-clipboard"></i> Cotizaciones</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('clientes', $client->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
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
                {{ $clients->links() }}
            </div>
            <!-- /.pagination -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection
