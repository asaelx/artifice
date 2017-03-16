<div class="row">
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('client_id', 'Cliente', ['class' => 'label']) }}
            {!! Form::select('client_id', $clients, null, ['class' => 'select2-add', 'id' => 'client_id', 'data-placeholder' => 'Selecciona un cliente']) !!}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('company', 'Empresa', ['class' => 'label']) }}
            {{ Form::input('text', 'company', ($estimate->client) ? $estimate->client->name : null, ['class' => 'input', 'id' => 'company']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('phone', 'Teléfono', ['class' => 'label']) }}
            {{ Form::input('text', 'phone', ($estimate->client) ? $estimate->client->phone : null, ['class' => 'input', 'id' => 'phone']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('email', 'Correo electrónico', ['class' => 'label']) }}
            {{ Form::input('email', 'email', ($estimate->client) ? $estimate->client->email : null, ['class' => 'input', 'id' => 'email']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('currency_id', 'Moneda', ['class' => 'label']) }}
            {{ Form::select('currency_id', $currencies, null, ['class' => 'select2', 'data-placeholder' => 'Selecciona una moneda']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('user_id', 'Vendedor', ['class' => 'label']) }}
            {{ Form::select('user_id', $users, null, ['class' => 'select2']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('status', 'Estado', ['class' => 'label']) }}
            {{ Form::select('status', ['Pendiente' => 'Pendiente', 'Aceptada' => 'Aceptada', 'Rechazada' => 'Rechazada'], null, ['class' => 'select2']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('expiration', 'Fecha de expiración', ['class' => 'label']) }}
            {{ Form::input('text', 'expiration', null, ['class' => 'input datepicker']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-12">
        <div class="form-group">
            {{ Form::label('notes', 'Notas', ['class' => 'label']) }}
            {{ Form::textarea('notes', null, ['size' => '10x3', 'class' => 'input autosizable']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-12">
        <div class="form-group">
            {{ Form::label('search', 'Buscar producto', ['class' => 'label']) }}
            {{ Form::select('search', ['0' => 'Buscar producto por nombre o código'], null, ['class' => 'select2-product', 'id' => 'search_product']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-12">
        <table class="table cotizador">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Foto</th>
                    <th>Descripción</th>
                    <th>Precio Unit.</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Total</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @unless ($estimate->estimate_details->isEmpty())
                    @foreach ($estimate->estimate_details as $estimate_detail)
                        @php
                            $product = $estimate_detail->product;
                            $price = ($product->sale_price != '') ? $product->sale_price : $product->regular_price;
                        @endphp
                        <tr>
                            <td data-th="Código">{{ $product->code }}</td>
                            <td data-th="Foto">
                                <div class="product-photo">
                                    {{ Html::image(($product->pictures->first()) ? url('storage/'.$product->pictures->first()->url) : url('storage/products/photo.jpg'), $product->title, ['class' => 'img']) }}
                                </div>
                                <!-- /.photo -->
                            </td>
                            <td data-th="Descripción">
                                <h4 class="product-title">{{ $product->title }}</h4>
                                <!-- /.product-title -->
                                @if($product->brand)
                                    <h5 class="product-brand"><b>Marca:</b> <i>{{ $product->brand->title }}</i></h5>
                                    <!-- /.product-brand -->
                                @endif
                                @if($product->category)
                                    <h5 class="product-category"><b>Categoría:</b> <i>{{ $product->category->title }}</i></h5>
                                    <!-- /.product-category -->
                                @endif
                                @if($product->dimensions)
                                    {{ Form::checkbox('estimate_details['.$product->id.'][show_dimensions]', 1, ($estimate_detail->show_dimensions) ? true : null) }} {{ Form::label('estimate_details['.$product->id.'][show_dimensions]', 'Mostrar dimensiones') }}
                                    <h5 class="product-dimensions"><b>Dimensiones:</b> <i>{{ $product->dimensions }}</i></h5>
                                    <!-- /.product-dimensions -->
                                @endif
                                <div class="product-description">
                                    {{ $product->description }}
                                </div>
                                <!-- /.product-description -->
                            </td>
                            <td data-th="Precio Unit.">
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
                            <td data-th="Cantidad">
                                {{ Form::input('number', 'estimate_details['.$product->id.'][qty]', $estimate_detail->quantity, ['class' => 'input qty', 'min' => '1', 'max' => ($product->stock > 0) ? $product->stock : '1']) }}
                            </td>
                            <td data-th="Descuento">
                                <span class="badge badge-green">{{ $estimate_detail->discount }}%</span>
                                <button class="unlock-discount btn btn-blue modal-trigger" data-modal="unlock-discount"," data-id="{{ $product->id }}"><i class="typcn typcn-lock-closed"></i></button>
                                @if($estimate_detail->discount > 0)
                                    {{ Form::hidden('estimate_details['.$product->id.'][discount]', $estimate_detail->discount, ['class' => 'discount']) }}
                                @endif
                            </td>
                            <td data-th="Total">
                                <span class="product-price-total price" data-price="{{ $price }}">${{ number_format((float) $estimate_detail->total, 2, '.', ',') }}</span>
                                {{ Form::input('hidden', 'estimate_details['.$product->id.'][total]', $estimate_detail->total, ['class' => 'input total', 'min' => '1', 'max' => '100']) }}
                            </td>
                            <td data-th="Opciones">
                                {{ Form::hidden('estimate_details['.$product->id.'][product_id]', $product->id) }}
                                @if ($estimate_detail->id)
                                    {{ Form::hidden('estimate_details['.$product->id.'][id]', $estimate_detail->id) }}
                                @endif
                                <button class="delete-row"><i class="typcn typcn-delete"></i> Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                @endunless
            </tbody>
            <tfoot>
                <tr class="subtotal">
                    <td colspan="6" class="tr"><b>Subtotal</b></td>
                    <td colspan="2"><span id="grand_subtotal" class="price">${{ ($estimate->subtotal) ? number_format((float) $estimate->subtotal, 2, '.', ',') : '0.00' }}</span></td>
                    {{ Form::hidden('subtotal', ($estimate->subtotal) ? $estimate->subtotal : 0) }}
                </tr>
                <tr class="tax">
                    <td colspan="6" class="tr"><b>I.V.A.</b></td>
                    <td colspan="2"><span id="tax" class="price" data-tax="{{ $settings->tax }}">{{ $settings->tax }}%</span></td>
                </tr>
                <tr class="total">
                    <td colspan="6" class="tr"><b>Total</b></td>
                    <td colspan="2"><span id="grand_total" class="price">${{ ($estimate->total) ? number_format((float) $estimate->total, 2, '.', ',') : '0.00' }}</span></td>
                    {{ Form::hidden('total', ($estimate->total) ? $estimate->total : 0) }}
                    {{ Form::hidden('discount', ($estimate->discount) ? $estimate->discount : 0) }}
                    {{ Form::hidden('save', ($estimate->save) ? $estimate->save : 0) }}
                </tr>
            </tfoot>
        </table>
        <!-- /.table -->
    </div>
    <!-- /.col-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-12">
        <div class="buttons pr">
            <button type="submit" class="btn btn-green"><i class="typcn typcn-printer"></i> Guardar</button>
        </div>
        <!-- /.tools -->
    </div>
    <!-- /.col-12 -->
</div>
<!-- /.row -->
