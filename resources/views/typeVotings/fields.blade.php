<!-- Prefix Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="clearfix"></div>
<!-- Name Field -->
<div class="form-group col-sm-3">
    {!! Form::label('anonymous', 'Anônimo:') !!}
    {!! Form::checkbox('anonymous', 1, isset($type_voting) ? $type_voting->anonymous : 0 , ['class' => 'form-control']) !!}
</div>

<!-- Active Field -->
<div class="form-group col-sm-3">
    {!! Form::label('active', 'Ativo:') !!}
    {!! Form::checkbox('active', 1, isset($type_voting) ? $type_voting->active : 0 , ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('typeVotings.index') !!}" class="btn btn-default">Cancelar</a>
</div>
