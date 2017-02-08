<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $settings->title }}</title>
        <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="screen">
    </head>
    <body>

        <section class="estimate-print">
            <header class="header">
                <div class="logo">
                    @if (isset($settings->sidebar_logo->url))
                        <img src="{{ asset('storage/'.$settings->estimate_logo->url) }}" alt="{{ $settings->title }}" class="img">
                    @else
                        <img src="{{ asset('img/logo_cotizacion.png') }}" alt="{{ $settings->title }}" class="img">
                    @endif
                </div>
                <!-- /.logo -->
                <div class="info">
                    <span class="data left"><b>Cotización Piezas en existencia</b></span>
                    <span class="data right"><b>Fecha:</b> {{ ucfirst(\Date::today()->format('d/m/Y')) }}</span>
                    <span class="data left"><b>Atención:</b> {{ $estimate->client->name }}</span>
                    <span class="data right"><b>Teléfono:</b> {{ $estimate->client->phone }}</span>
                    <span class="data left"><b>E-mail:</b> {{ $estimate->client->email }}</span>
                    <span class="data right"><b>Vendedor:</b> {{ $estimate->user->name }}</span>
                </div>
                <!-- /.info -->
            </header>
            <!-- /.header -->
            <table class="estimate-table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>No. Art.</th>
                        <th>Descripción</th>
                        <th>P. Unit.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estimate->estimate_details as $estimate_detail)
                        @php
                            $product = $estimate_detail->product;
                            $price = ($product->sale_price != '') ? $product->sale_price : $product->regular_price;
                            $price = number_format((float) $price, 2, '.', ',');
                        @endphp
                        <tr>
                            <td>
                                <div class="product-photo">
                                    {{ Html::image(($product->pictures->first()) ? url('storage/'.$product->pictures->first()->url) : url('storage/products/photo.jpg'), $product->title, ['class' => 'img']) }}
                                </div>
                                <!-- /.photo -->
                            </td>
                            <td><span class="qty">{{ $estimate_detail->quantity }} PZ{{ ($estimate_detail->quantity > 1) ? 'S' : '' }}</span></td>
                            <td>
                                <h5 class="product-brand"><b>Modelo:</b> <i>{{ $product->code }}</i></h5>
                                <!-- /.product-brand -->
                                <h4 class="product-title">{{ $product->title }}</h4>
                                <!-- /.product-title -->
                                @if($estimate_detail->show_dimensions)
                                    <h5 class="product-dimensions"><b>Dimensiones:</b> <i>{{ $product->dimensions }}</i></h5>
                                    <!-- /.product-dimensions -->
                                @endif
                            </td>
                            <td>
                                @php
                                    $regular_price = number_format((float) $product->regular_price, 2, '.', ',');
                                @endphp
                                <h5 class="price {{ ($product->sale_price != '') ? 'with-sale' : '' }}">${{ $regular_price }}</h5>
                                @if($product->sale_price != '')
                                    @php
                                        $sale_price = number_format((float) $product->sale_price, 2, '.', ',');
                                    @endphp
                                    <h5 class="price">$'.$sale_price.'</h5>
                                @endif
                            </td>
                            <td>
                                <span class="product-price-total price" data-price="{{ $price }}">${{ number_format((float) $estimate_detail->total, 2, '.', ',') }}</span>
                            </td>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="subtotal">
                        <td colspan="4" class="tr"><b>Subtotal</b></td>
                        <td colspan="1"><span class="price">${{ ($estimate->subtotal) ? number_format((float) $estimate->subtotal, 2, '.', ',') : '0.00' }}</span></td>
                    </tr>
                        <td colspan="4" class="tr"><b>I.V.A.</b></td>
                        <td colspan="1"><span class="price" data-tax="{{ $settings->tax }}">{{ $settings->tax }}%</span></td>
                    </tr>
                    <tr class="total">
                        <td colspan="4" class="tr"><b>Total</b></td>
                        <td colspan="1"><span class="price">${{ ($estimate->total) ? number_format((float) $estimate->total, 2, '.', ',') : '0.00' }}</span></td>
                    </tr>
                </tfoot>
            </table>
            <!-- /.estimate-table -->
            @if ($estimate->notes != '')
                <div class="notes">
                    <h3 class="title">Notas:</h3>
                    <!-- /.title -->
                    <div class="content">{{ $estimate->notes }}</div>
                    <!-- /.content -->
                </div>
                <!-- /.notes -->
            @endif
            <div class="observations">
                <div class="left">
                    <h3 class="title">Observaciones:</h3>
                    <!-- /.title -->
                    <div class="content">
                        {!! nl2br($settings->observations) !!}
                    </div>
                    <!-- /.content -->
                </div>
                <!-- /.left -->
                <div class="right">
                    <div class="signature">
                        <p>Atte.</p>
                        <p>{{ $estimate->user->name }}</p>
                        <p>{{ $settings->title }}</p>
                    </div>
                    <!-- /.signature -->
                </div>
                <!-- /.right -->

            </div>
            <!-- /.observations -->
            <footer class="footer">
                <div class="address">{{ $settings->address }}</div>
                <div class="contact">
                    <span class="phone">Tel. {{ $settings->phone }}</span>
                    <span class="email">{{ $settings->email }}</span>
                    <span class="store">{{ $settings->store_url }}</span>
                </div>
                <!-- /.contact -->
                <!-- /.address -->
            </footer>
            <!-- /.footer -->
        </section>
        <!-- /.estimate-print -->
    </body>
</html>
