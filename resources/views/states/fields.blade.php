{!! Form::token() !!}
<div class="form-group col-sm-12"><h3>Cadastro</h3><hr></div>
<!--- Uf Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('uf', 'Uf:') !!}
	{!! Form::text('uf', null, ['class' => 'form-control']) !!}
</div>

<!--- Name Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('name', 'Name:') !!}
	{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<!--- Submit Field --->
<div class="form-group col-sm-12">
    {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
</div>
