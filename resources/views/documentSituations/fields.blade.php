    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Active Field -->
        <div class="form-group col-sm-2">
            {!! Form::label('active', 'Ativo:') !!}
            <div class="form-check form-switch form-switch-md">
                <input
                    id="active"
                    name="active"
                    class="form-check-input"
                    type="checkbox"
                    @if(isset($documentSituation->active) ? $documentSituation->active == 1:false)
                    checked
                    @endif
                >
            </div>
        </div>


        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('documentSituations.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
