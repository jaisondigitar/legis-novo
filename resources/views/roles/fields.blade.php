{!! Form::token() !!}

<!--- Name Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('name', 'Grupo / Regra:') !!}
	{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>



<!--- Submit Field --->
<div class="form-group col-sm-12 text-right mt-3">
    <a href="{{ URL::previous() }}"><button type="button" class="btn btn-default">Cancelar</button></a>
    {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
</div>
