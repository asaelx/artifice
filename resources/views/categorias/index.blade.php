@extends('layout.base')

@section('title', 'Categorías')
@section('sectionTitle', 'Categorías')
@section('add')
    <div class="buttons pr">
        <a href="{{ url('categorias/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Agregar categoría</a>
    </div>
    <!-- /.buttons -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($categories->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay categorías</h2>
                    <!-- /.title -->
                    <a href="{{ url('categorias/nuevo') }}" class="btn btn-blue">Agregar una categoría</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Productos</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td data-th="Título">{{ $category->title }}</td>
                                <td data-th="Descripción">{{ $category->description }}</td>
                                <td data-th="Productos">{{ $category->products()->count() }}</td>
                                <td data-th="Opciones">
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('categorias/'.$category->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="{{ url('categorias/'.$category->id.'/exportProducts') }}" class="link"><i class="typcn typcn-download"></i> Excel Productos</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('categorias', $category->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
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
                {{ $categories->links() }}
            </div>
            <!-- /.pagination -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection
