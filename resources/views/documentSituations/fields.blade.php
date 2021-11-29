<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Active Field -->
<div class="form-group col-sm-2">
    {!! Form::label('active', 'Ativo:') !!}
    <div class="clearfix"></div>
    {!! Form::checkbox('active', 1, null, ['class' => 'form-control switch' , 'data-on-text' => 'Sim', 'data-off-text' => 'Não', 'data-off-color' => 'danger', 'data-on-color' => 'success', 'data-size' => 'normal', 'type' => 'checkbox' ]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('documentSituations.index') !!}" class="btn btn-default">Cancelar</a>
</div>
