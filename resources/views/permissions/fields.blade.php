{!! Form::token() !!}
<!--- Id Field --->


<!--- Name Field --->
<div class="form-group col-sm-3 col-lg-3">
    {!! Form::label('name', 'Slug:') !!}
	{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!--- Readable Name Field --->
<div class="form-group col-sm-9 col-lg-9">
    {!! Form::label('readable_name', 'Descrição:') !!}
	{!! Form::text('readable_name', null, ['class' => 'form-control']) !!}
</div>

<!--- Submit Field --->
<div class="form-group col-sm-12 text-right">
    <a href="{{ URL::previous() }}"><button type="button" class="btn btn-info">Cancelar</button></a>
    {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
</div>
