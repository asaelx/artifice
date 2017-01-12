@extends('layout.base')

@section('title', 'Inicio')
@section('sectionTitle', 'Inicio')

@section('content')
    <div class="row">

        <div class="col-4">
            <div class="counter">
                <div class="row">
                    <div class="col-5 icon"><i class="typcn typcn-clipboard"></i></div>
                    <!-- /.col-5 -->
                    <div class="col-7 count">
                        <span class="qty">{{ $estimates->count() }}</span>
                        <span class="title">{{ ($estimates->count() > 1) ? 'Cotizaciones' : 'Cotización' }}</span>
                    </div>
                    <!-- /.col-7 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.counter -->
        </div>
        <!-- /.col-4 -->

        <div class="col-4">
            <div class="counter">
                <div class="row">
                    <div class="col-5 icon"><i class="typcn typcn-group"></i></div>
                    <!-- /.col-5 -->
                    <div class="col-7 count">
                        <span class="qty">{{ $clients->count() }}</span>
                        <span class="title">{{ ($clients->count() > 1) ? 'Clientes' : 'Cliente' }}</span>
                    </div>
                    <!-- /.col-7 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.counter -->
        </div>
        <!-- /.col-4 -->

        <div class="col-4">
            <div class="counter">
                <div class="row">
                    <div class="col-5 icon"><i class="typcn typcn-th-list"></i></div>
                    <!-- /.col-5 -->
                    <div class="col-7 count">
                        <span class="qty">{{ $products->count() }}</span>
                        <span class="title">{{ ($products->count() > 1) ? 'Productos' : 'Producto' }}</span>
                    </div>
                    <!-- /.col-7 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.counter -->
        </div>
        <!-- /.col-4 -->

    </div>
    <!-- /.row -->

    <div class="row">

        <div class="col-4">
            <div class="counter">
                <div class="row">
                    <div class="col-5 icon"><i class="typcn typcn-tags"></i></div>
                    <!-- /.col-5 -->
                    <div class="col-7 count">
                        <span class="qty">{{ $brands->count() }}</span>
                        <span class="title">{{ ($brands->count() > 1) ? 'Marcas' : 'Marca' }}</span>
                    </div>
                    <!-- /.col-7 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.counter -->
        </div>
        <!-- /.col-4 -->

        <div class="col-4">
            <div class="counter">
                <div class="row">
                    <div class="col-5 icon"><i class="typcn typcn-tags"></i></div>
                    <!-- /.col-5 -->
                    <div class="col-7 count">
                        <span class="qty">{{ $categories->count() }}</span>
                        <span class="title">{{ ($categories->count() > 1) ? 'Categorías' : 'Categoría' }}</span>
                    </div>
                    <!-- /.col-7 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.counter -->
        </div>
        <!-- /.col-4 -->

        <div class="col-4">
            <div class="counter">
                <div class="row">
                    <div class="col-5 icon"><i class="typcn typcn-user"></i></div>
                    <!-- /.col-5 -->
                    <div class="col-7 count">
                        <span class="qty">{{ $users->count() }}</span>
                        <span class="title">{{ ($users->count() > 1) ? 'Usuarios' : 'Usuario' }}</span>
                    </div>
                    <!-- /.col-7 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.counter -->
        </div>
        <!-- /.col-4 -->

    </div>
    <!-- /.row -->
@endsection
