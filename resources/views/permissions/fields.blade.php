<div class="row">
    {!! Form::token() !!}

    <!--- Name Field --->
    <div class="form-group col-sm-3">
        {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!--- Readable Name Field --->
    <div class="form-group col-sm-9">
        {!! Form::label('readable_name', 'Descrição:', ['class' => 'required']) !!}
        {!! Form::text('readable_name', null, ['class' => 'form-control']) !!}
    </div>

    <!--- Submit Field --->
    <div class="form-group col-sm-12 text-right mt-3">
        <a href="{{ URL::previous() }}">
            <button type="button" class="btn btn-default btn-sm">Cancelar</button>
        </a>
        {!! Form::submit('SALVAR', ['class' => 'btn btn-success btn-sm']) !!}
    </div>
</div>
