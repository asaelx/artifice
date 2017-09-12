@extends('layout.base')

@section('title', 'Productos')
@section('sectionTitle', 'Productos')
@section('add')
    <div class="buttons pr">
        <button class="btn btn-green modal-trigger" data-modal="upload-excel"><i class="typcn typcn-plus"></i> Importar productos</button>
        <a href="{{ url('productos/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Agregar producto</a>
    </div>
    <!-- /.buttons -->
@endsection

@section('content')
    @unless ($products->isEmpty())
        <div class="row">
            {{ Form::open(['url' => url('productos'), 'class' => 'form search', 'method' => 'GET']) }}
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('title', 'Título', ['class' => 'label']) }}
                        {{ Form::input('text', 'title', ($request->has('title')) ? $request->input('title') : null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('code', 'Código', ['class' => 'label']) }}
                        {{ Form::input('text', 'code', ($request->has('code')) ? $request->input('code') : null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('brand_id', 'Marca', ['class' => 'label']) }}
                        {{ Form::select('brand_id', $brands, ($request->has('brand_id')) ? $request->input('brand_id') : null, ['class' => 'select2', 'data-placeholder' => 'Selecciona Marca']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('category_id', 'Categoría', ['class' => 'label']) }}
                        {{ Form::select('category_id', $categories, ($request->has('category_id')) ? $request->input('category_id') : null, ['class' => 'select2', 'data-placeholder' => 'Selecciona Categoría']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-12">
                    <div class="form-group">
                        {{ Form::submit('Buscar', ['class' => 'btn btn-green']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-12 -->
            {{ Form::close() }}
        </div>
        <!-- /.row -->
    @endunless
    <div class="row">
        <div class="col-12">
            @if ($products->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">No se encontraron resultados</h2>
                    <!-- /.title -->
                    <a href="{{ url('productos/nuevo') }}" class="btn btn-blue">Agregar un producto</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Foto</th>
                            <th>Descripción</th>
                            <th>Disponibles</th>
                            <th>Precio</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td data-th="Código">{{ $product->code }}</td>
                                <td data-th="Foto">
                                    <div class="product-photo">
                                        @if ($product->pictures()->first())
                                            {{ Html::image(asset('storage/'.$product->pictures()->first()->url), $product->title, ['class' => 'img']) }}
                                        @endif
                                    </div>
                                    <!-- /.photo -->
                                </td>
                                <td data-th="Descripción">
                                    <h4 class="product-title">{{ $product->title }}</h4>
                                    <!-- /.product-title -->
                                    @if ($product->brand)
                                        <h5 class="product-brand"><b>Marca:</b> <i>{{ $product->brand->title }}</i></h5>
                                        <!-- /.product-brand -->
                                    @endif
                                    @if ($product->category)
                                        <h5 class="product-category"><b>Categoría:</b> <i>{{ $product->category->title }}</i></h5>
                                        <!-- /.product-category -->
                                    @endif
                                    @if ($product->dimensions)
                                        <h5 class="product-dimensions"><b>Dimensiones:</b> <i>{{ $product->dimensions }}</i></h5>
                                        <!-- /.product-dimensions -->
                                    @endif
                                    <div class="product-description">
                                        {{ $product->description }}
                                    </div>
                                    <!-- /.product-description -->
                                </td>
                                <td data-th="Disponibles">{{ $product->stock }}</td>
                                <td data-th="Precio">
                                    <span class="price {{ ($product->sale_price != '') ? 'with-sale' : '' }}">${{ number_format((float) $product->regular_price, 2, '.', ',') }}</span>
                                    {!! ($product->sale_price != '') ? '<span class="price">$'.number_format((float) $product->sale_price, 2, '.', ',').'</span>' : '' !!}
                                </td>
                                <td data-th="Opciones">
                                    <span class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('productos/'.$product->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('productos', $product->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
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
                {{ $products->appends($request->all())->links() }}
            </div>
            <!-- /.pagination -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection

@section('modal')
    <div class="layer" id="upload-excel-modal">
        <div class="modal">
            <h3 class="title"><i class="typcn typcn-storage"></i> Subir archivo <button class="close-modal"><i class="typcn typcn-times"></i></button></h3>
            <!-- /.title -->
            <div class="content">
                <div class="row">
                    <div class="col-12">
                        <p>Asegúrate que los títulos de las columnas sean:</p>
                        <p><b>title, description, code, stock, regular_price, sale_price, brand_id, category_id</b></p>
                    </div>
                    <!-- /.col-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        {{ Form::open(['url' => url('productos/importProducts'), 'files' => true,'class' => 'form']) }}
                            <div class="form-group">
                                {{ Form::label('file', 'Selecciona un archivo .xsl, .xlsx o .csv', ['class' => 'label']) }}
                                {{ Form::file('file', ['required']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::submit('Cargar productos', ['class' => 'btn btn-green']) }}
                            </div>
                            <!-- /.form-group -->
                        {{ Form::close() }}
                    </div>
                    <!-- /.col-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- /.layer -->
@endsection
