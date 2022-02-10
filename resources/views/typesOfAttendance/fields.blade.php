<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Active Field -->
<div class="form-group col-sm-6">
    <span>Ativo</span><br>
    <label for="external">
        <input
            name="active"
            id="external"
            class="switch"
            data-on-text="Sim"
            data-off-text="Não"
            data-off-color="danger"
            data-on-color="success"
            data-size="normal"
            type="checkbox"
            @if(isset($types_of_attendance->active))
               {!! 'checked' !!}
            @else
                checked
            @endif
        >
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('typesOfAttendance.index') !!}" class="btn btn-default">Cancelar</a>
</div>
