    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Name:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-3">
            {!! Form::label('prefix', 'Prefix:') !!}
            {!! Form::text('prefix', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
            <a href="{!! route('lawsStructures.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
