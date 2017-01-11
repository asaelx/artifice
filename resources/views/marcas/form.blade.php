<div class="form-group">
    {{ Form::label('title', 'Título', ['class' => 'label']) }}
    {{ Form::input('text', 'title', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('description', 'Descripción', ['class' => 'label']) }}
    {{ Form::input('text', 'description', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-green']) }}
    {{ Html::link(url('marcas'), 'Cancelar', ['class' => 'btn btn-red']) }}
</div>
<!-- /.form-group -->
