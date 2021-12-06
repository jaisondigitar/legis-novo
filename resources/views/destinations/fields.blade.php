{!! Form::token() !!}
<div class="form-group col-sm-12"><h3>Cadastro</h3><hr></div>

<!--- Name Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
	{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!--- Email Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('email', 'Email:') !!}
	{!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!--- Submit Field --->
<div class="form-group col-sm-12">
    {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
</div>
