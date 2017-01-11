@extends('layout.base')

@section('title', 'Marcas')
@section('sectionTitle', 'Marcas')
@section('add')
    <a href="{{ url('marcas/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Agregar marca</a>
@endsection

@section('content')
    @unless ($brands->isEmpty())
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
                        {{ Form::label('description', 'Descripción', ['class' => 'label']) }}
                        {{ Form::input('text', 'description', null, ['class' => 'input']) }}
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
            @if ($brands->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay marcas</h2>
                    <!-- /.title -->
                    <a href="{{ url('marcas/nuevo') }}" class="btn btn-blue">Agregar una marca</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $brand->title }}</td>
                                <td>{{ $brand->description }}</td>
                                <td>
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('marcas/'.$brand->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('marcas', $brand->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
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
