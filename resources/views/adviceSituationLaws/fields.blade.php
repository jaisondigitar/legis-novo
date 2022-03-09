    <div class="row">
        <!-- Date Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Situação:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
            <a href="{!! route('adviceSituationLaws.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
