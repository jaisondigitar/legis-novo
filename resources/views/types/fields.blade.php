<!-- Prefix Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prefix', 'Prefixo:') !!}
    {!! Form::text('prefix', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
    <a href="{!! route('types.index') !!}" class="btn btn-default">Cancelar</a>
</div>
