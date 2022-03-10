
    <div class="row" style="margin: 0 3.125rem 0 3.125rem">
        <div class="the-box-rounded">
            <!-- Name Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <!-- Submit Field -->
            <div class="form-group col-sm-12 mt-3">
                {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
                <a href="{!! route('lawsTypes.index') !!}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </div>
