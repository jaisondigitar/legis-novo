    <div class="row">
        <!-- Companies Id Field -->
        <div class="form-group col-sm-6" style="display:none">
            {!! Form::label('companies_id', 'Companies Id:') !!}
            {!! Form::text('companies_id', Auth::user()->company->id, ['class' => 'form-control']) !!}
        </div>

        <!-- Prefix Field -->
        <div class="form-group col-sm-2">
            {!! Form::label('prefix', 'Sigla:', ['class' => 'required']) !!}
            {!! Form::text('prefix', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('parties.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
