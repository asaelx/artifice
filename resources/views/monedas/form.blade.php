<div class="form-group">
    {{ Form::label('title', 'Título', ['class' => 'label']) }}
    {{ Form::input('text', 'title', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('code', 'Código', ['class' => 'label']) }}
    {{ Form::input('text', 'code', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('symbol', 'Símbolo', ['class' => 'label']) }}
    {{ Form::input('text', 'symbol', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('precision', 'Precisión', ['class' => 'label']) }}
    {{ Form::input('text', 'precision', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-green']) }}
    {{ Html::link(url('monedas'), 'Cancelar', ['class' => 'btn btn-red']) }}
</div>
<!-- /.form-group -->
