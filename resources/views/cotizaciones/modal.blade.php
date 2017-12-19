<div class="layer" id="unlock-discount-modal">
    <div class="modal">
        <h3 class="title"><i class="typcn typcn-lock-closed"></i> Autorizar descuento <button class="close-modal"><i class="typcn typcn-times"></i></button></h3>
        <!-- /.title -->
        <div class="content">
            {{ Form::open(['url' => url('cotizaciones/unlockDiscount/{id}'), 'class' => 'form']) }}
                <div class="form-group">
                    {{ Form::label('discount_code', 'Código de autorización', ['class' => 'label']) }}
                    {{ Form::input('password', 'discount_code', null, ['class' => 'input']) }}
                </div>
                <div class="form-group">
                    {{ Form::submit('Desbloquear', ['class' => 'btn btn-green']) }}
                </div>
                <!-- /.form-group -->
            {{ Form::close() }}
        </div>
        <!-- /.content -->
    </div>
    <!-- /.modal -->
</div>
<!-- /.layer -->
