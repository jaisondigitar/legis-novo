<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-3">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('typesOfAttendance.index') !!}" class="btn btn-default">Cancelar</a>
</div>
