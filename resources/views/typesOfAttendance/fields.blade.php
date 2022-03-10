    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Active Field -->
        <div class="form-group col-sm-6">
            <span>Ativo</span><br>
            <label for="external">
                <div class="form-check form-switch form-switch-md">
                <input
                    name="active"
                    id="external"
                    class="form-check-input"
                    type="checkbox"
                    @if(isset($types_of_attendance->active))
                       {!! 'checked' !!}
                    @else
                        checked
                    @endif
                >
                </div>
            </label>
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
            <a href="{!! route('typesOfAttendance.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
