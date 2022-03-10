    <div class="row">
        <!-- Date Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('date', 'Date:') !!}
            {!! Form::text('date', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Type Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('type', 'Type:') !!}
            {!! Form::text('type', null, ['class' => 'form-control']) !!}
        </div>

        <!-- To Id Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('to_id', 'To Id:') !!}
            {!! Form::text('to_id', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('$ROUTES_AS_PREFIX$advices.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
