{!! Form::token() !!}
<div class="form-group col-sm-12"><h3>Cadastro</h3><hr></div>
<!--- Name Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
	{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!--- Token Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('token', 'Token:', ['class' => 'required']) !!}
	{!! Form::text('token', null, ['class' => 'form-control']) !!}
    <a href="#" onclick="createHash('{{ $module->name ?? time() }}');return false;"><span class="btn btn-info">Criar token</span></a>
</div>

<!--- Active Field --->
<div class="form-group col-sm-6 col-lg-4">
    <div class="checkbox">
		<label>{!! Form::checkbox('active', 1, true) !!}Active</label>
	</div>
</div>


<!--- Submit Field --->
<div class="form-group col-sm-12">
    {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
</div>
