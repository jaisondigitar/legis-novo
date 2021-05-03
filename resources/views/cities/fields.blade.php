{!! Form::token() !!}
<!--- Code Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('code', 'Code:') !!}
	{!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!--- State Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('state', 'State:') !!}
	{!! Form::text('state', null, ['class' => 'form-control']) !!}
</div>

<!--- Name Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('name', 'Name:') !!}
	{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<!--- Submit Field --->
<div class="form-group col-sm-12 text-right">
    <a href="{{ URL::previous() }}"><button type="button" class="btn btn-info">Cancelar</button></a>
    {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
</div>
