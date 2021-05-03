{!! Form::token() !!}
<div class="form-group col-sm-12"><h3>Cadastro</h3><hr></div>
<!--- User Id Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('user_id', 'User Id:') !!}
	{!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!--- Image Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('image', 'Image:') !!}
	{!! Form::file('image') !!}
</div>

<!--- Fullname Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('fullName', 'Fullname:') !!}
	{!! Form::text('fullName', null, ['class' => 'form-control']) !!}
</div>

<!--- About Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('about', 'About:') !!}
	{!! Form::textarea('about', null, ['class' => 'form-control']) !!}
</div>

<!--- Facebook Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('facebook', 'Facebook:') !!}
	{!! Form::text('facebook', null, ['class' => 'form-control']) !!}
</div>

<!--- Twitter Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('twitter', 'Twitter:') !!}
	{!! Form::text('twitter', null, ['class' => 'form-control']) !!}
</div>

<!--- Linkedin Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('linkedin', 'Linkedin:') !!}
	{!! Form::text('linkedin', null, ['class' => 'form-control']) !!}
</div>

<!--- Instagram Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('instagram', 'Instagram:') !!}
	{!! Form::text('instagram', null, ['class' => 'form-control']) !!}
</div>

<!--- City Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('city', 'City:') !!}
	{!! Form::select('city', [], null, ['class' => 'form-control']) !!}
</div>

<!--- State Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('state', 'State:') !!}
	{!! Form::select('state', [], null, ['class' => 'form-control']) !!}
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
