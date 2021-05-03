{!! Form::token() !!}
<div class="form-group col-sm-12"><h3>Cadastro</h3><hr></div>
<!--- Image Field --->
<div class="form-group col-sm-6 col-lg-4">
    @if(isset($company) && !empty($company->image))
        <div class="logo-inst">
            <img src="{{ url('uploads/company/'. $company->image) }}">
            <div style="width: 100px;padding: 5px;font-family: monospace;">
                <a href="#" onclick="removeImage()"><i class="fa fa-remove"></i> Remover</a>
            </div>
        </div>
    @else
        <div class="upload">
            <i class="fa fa-image"></i>
            {!! Form::label('image', " Logo:") !!}
            {!! Form::file('image') !!}
        </div>
    @endif

</div>

<!--- Shortname Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('shortName', 'Nome Fantasia:') !!}
	{!! Form::text('shortName', null, ['class' => 'form-control']) !!}
</div>

<!--- Fullname Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('fullName', 'Rasão Social:') !!}
	{!! Form::text('fullName', null, ['class' => 'form-control']) !!}
</div>

<!--- Email Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('email', 'Email:') !!}
	{!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!--- Phone1 Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('phone1', 'Telefone 1:') !!}
	{!! Form::text('phone1', null, ['class' => 'form-control phone']) !!}
</div>

<!--- Phone2 Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('phone2', 'Telefone 2:') !!}
	{!! Form::text('phone2', null, ['class' => 'form-control phone']) !!}
</div>

<!--- Mayor Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('mayor', 'Responsável:') !!}
	{!! Form::text('mayor', null, ['class' => 'form-control']) !!}
</div>

<!--- Cnpjcpf Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('cnpjCpf', 'Cnpj:') !!}
	{!! Form::text('cnpjCpf', null, ['class' => 'form-control cpfcnpj']) !!}
</div>

<!--- Ierg Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('ieRg', 'Insc. Estadual:') !!}
	{!! Form::text('ieRg', null, ['class' => 'form-control']) !!}
</div>

<!--- Im Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('im', 'Insc. Municipal:') !!}
	{!! Form::text('im', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('address', 'Endereço:') !!}
	{!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!--- State Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('state', 'UF:') !!}
    {!! Form::select('state', $states, null, ['class' => 'form-control states', 'onChange'=>'getCities(\'state\')']) !!}
</div>

<!--- City Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('city', 'Cidade:') !!}
	{!! Form::select('city', $cities, null, ['class' => 'form-control cities']) !!}
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

<script>
    function removeImage() {
        var id = '{{$company->id}}';
        var r = confirm("Deseja remover a imagem?");
        if (r == true) {
            $.ajax({
                url: "{{ url('config/companies/removeImage') }}/" + id,
                type: 'GET',
                dataType: 'json'
            }).done(function (result) {
                if(result == true) {
                    location.reload();
                } else {
                    alert('Tente Novamente1')
                }

            });
        }
    }
</script>
