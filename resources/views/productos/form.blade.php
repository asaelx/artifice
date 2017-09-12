<div class="form-group">
    {{ Form::label('photos[]', 'Fotos', ['class' => 'label']) }}
    @if (isset($product->pictures) && $product->pictures())
        @foreach ($product->pictures as $picture)
            <div class="picture">
                {{ Html::image(asset('storage/'.$picture->url), $picture->origina_name, ['class' => 'img']) }}
            </div>
            <!-- /.picture -->
        @endforeach
    @endif
    {{ Form::file('photos[]', ['class' => 'file', 'multiple']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('title', 'Título', ['class' => 'label']) }}
    {{ Form::input('text', 'title', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('description', 'Descripción', ['class' => 'label']) }}
    {{ Form::textarea('description', null, ['size' => '10x3', 'class' => 'input autosizable']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('dimensions', 'Dimensiones', ['class' => 'label']) }}
    {{ Form::input('text', 'dimensions', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('code', 'Código', ['class' => 'label']) }}
    {{ Form::input('text', 'code', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('stock', 'Cantidad', ['class' => 'label']) }}
    {{ Form::input('text', 'stock', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('regular_price', 'Precio regular', ['class' => 'label']) }}
    {{ Form::input('text', 'regular_price', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('sale_price', 'Precio de oferta', ['class' => 'label']) }}
    {{ Form::input('text', 'sale_price', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('brand_id', 'Marca', ['class' => 'label']) }}
    {{ Form::select('brand_id', $brands, null, ['class' => 'select2-add', 'data-placeholder' => 'Selecciona una marca', 'data-tags' => true]) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('category_id', 'Categoría', ['class' => 'label']) }}
    {{ Form::select('category_id', $categories, null, ['class' => 'select2-add', 'data-placeholder' => 'Selecciona una categoría', 'data-tags' => true]) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-green']) }}
    {{ Html::link(url('productos'), 'Cancelar', ['class' => 'btn btn-red']) }}
</div>
<!-- /.form-group -->
