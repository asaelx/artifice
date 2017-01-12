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
                    <img src="{{ asset('storage/'.$settings->estimate_logo->url) }}" alt="{{ $settings->title }}" class="img">
                </div>
                <!-- /.logo -->
                <div class="info">
                    <span class="data"><b>Cotización Piezas en existencia</b></span>
                    <span class="data"><b>Fecha:</b> {{ \Date::today()->toFormattedDateString() }}</span>
                    <span class="data"><b>Atención:</b> {{ $estimate->client->name }}</span>
                    <span class="data"><b>Teléfono:</b> {{ $estimate->client->phone }}</span>
                    <span class="data"><b>E-mail:</b> {{ $estimate->client->email }}</span>
                    <span class="data"><b>Vendedor:</b> {{ $estimate->user->name }}</span>
                </div>
                <!-- /.info -->
            </header>
            <!-- /.header -->
            <table class="estimate-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Descripción</th>
                        <th>P. Unit.</th>
                        <th>Cant.</th>
                        <th>Desc.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estimate->estimate_details as $estimate_detail)
                        @php
                            $product = $estimate_detail->product;
                            $price = ($product->sale_price != '') ? $product->sale_price : $product->regular_price;
                        @endphp
                        <tr>
                            <td>
                                <div class="product-photo">
                                    {{ Html::image(url('storage/'.$product->pictures->first()->url), $product->title, ['class' => 'img']) }}
                                </div>
                                <!-- /.photo -->
                            </td>
                            <td>
                                <h4 class="product-title">{{ $product->title }}</h4>
                                <!-- /.product-title -->
                                <h5 class="product-brand"><b>Marca:</b> <i>{{ $product->brand->title }}</i></h5>
                                <!-- /.product-brand -->
                                <h5 class="product-category"><b>Categoría:</b> <i>{{ $product->category->title }}</i></h5>
                                <!-- /.product-category -->
                                <div class="product-description">
                                    {{ $product->description }}
                                </div>
                                <!-- /.product-description -->
                            </td>
                            <td>
                                <h5 class="price {{ ($product->sale_price != '') ? 'with-sale' : '' }}">${{ $product->regular_price }}</h5>
                                {!! ($product->sale_price != '') ? '<h5 class="price">$'.$product->sale_price.'</h5>' : '' !!}
                            </td>
                            <td><span class="qty">&times; {{ $estimate_detail->quantity }}</span></td>
                            <td><span class="badge badge-green discount">{{ $estimate_detail->discount }}%</span></td>
                            <td>
                                <span class="product-price-total price" data-price="{{ $price }}">${{ $price }}</span>
                            </td>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="subtotal">
                        <td colspan="5" class="tr"><b>Subtotal</b></td>
                        <td colspan="2"><span class="price">${{ ($estimate->subtotal) ? $estimate->subtotal : '0.00' }}</span></td>
                    </tr>
                    <tr class="discount">
                        <td colspan="5" class="tr"><b>Con descuento</b></td>
                        <td colspan="2"><span class="price">${{ ($estimate->discount) ? $estimate->discount : '0.00' }}</span></td>
                    </tr>
                    <tr class="save">
                        <td colspan="5" class="tr"><b>Usted ahorra</b></td>
                        <td colspan="2"><span class="price">${{ ($estimate->save) ? $estimate->save : '0.00' }}</span></td>
                    </tr>
                    <tr class="tax">
                        <td colspan="5" class="tr"><b>I.V.A.</b></td>
                        <td colspan="2"><span class="price" data-tax="{{ $settings->tax }}">{{ $settings->tax }}%</span></td>
                    </tr>
                    <tr class="total">
                        <td colspan="5" class="tr"><b>Total</b></td>
                        <td colspan="2"><span class="price">${{ ($estimate->total) ? $estimate->total : '0.00' }}</span></td>
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
                        <p>En PEDIDOS, el anticipo será del 70% del TOTAL y el saldo el 30% contra entrega de la mercancía.</p>
                        <p>En APARTADOS, el anticipo será del 50% del TOTAL y el saldo contra entrega de la mercancia.</p>
                        <p>El tiempo máximo de apartado será de 2 meses. En caso de haber cumplido el plazo ó la mercancia sea cancelada después de este período, tendrá una penalización del 5% sobre el total del apartado.</p>
                        <p>Precios sujetos a cambios sin previo aviso. Toda vez efectuado el pago del anticipo, el precio del articulo no variará.</p>
                        <p>Los precios son en MXN y NO INCLUYEN IVA.</p>
                        <p>NO se aceptan cambios ni devoluciones.</p>
                        <p>La válidez de esta cotización es por 5 días y dependerá de la disponibilidad de las piezas.</p>
                    </div>
                    <!-- /.content -->
                </div>
                <!-- /.left -->
                <div class="right">
                    <div class="signature">
                        <p>Atte.</p>
                        <p>{{ $settings->owner }}</p>
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
