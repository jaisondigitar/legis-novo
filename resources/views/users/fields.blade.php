{!! Form::token() !!}
<div class="form-group col-sm-12"><h3>Cadastro</h3><hr></div>
<!--- Id Field --->
<div class="form-group col-sm-6 col-lg-4" style="display: none;">
    {!! Form::label('id', 'Id:') !!}
	{!! Form::number('id', null, ['class' => 'form-control']) !!}
</div>

<!--- Institute Id Field --->
<div class="form-group col-sm-6 col-lg-4" style="display: none;">
    {!! Form::label('company_id', 'Company:') !!}
	{!! Form::number('company_id', Auth::user()->company->id, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('sector_id', 'Setor:', ['class' => 'required']) !!}
    {!! Form::select('sector_id', $sectors, null, ['class' => 'form-control', 'required']) !!}
</div>

<!--- Name Field --->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('name', 'Name:', ['class' => 'required']) !!}
	{!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!--- Email Field --->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('email', 'Email:', ['class' => 'required']) !!}
	{!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!--- Password Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('password', 'Senha:', ['class' => 'required']) !!}
	{!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!--- Active Field --->
<div class="form-group col-sm-6 col-lg-2">
    <span>Ativo</span><br>
    <label for="active">
        <input name="active" id="active" class="switch" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal" type="checkbox"
            @if(isset($user))
                {!! $user->active>0?'checked':'' !!}
            @else
                checked
            @endif
        >
    </label>
</div>

<div class="form-group col-sm-12">
    <div class="the-box bg-success no-border">
        <h4 class="small-title required">GRUPO DE PERMISSÕES:</h4>
        @foreach($levels as $value)
            <?php
                $teste = false;
                if(isset($user)){
                    $teste = $user->hasRole($value->name);
                }
            ?>
            <div class="col-sm-2">
                {!! Form::checkbox('roles[]', $value->id, $teste, ['class' => 'required']) !!}
                {{ $value->name }}
            </div>
        @endforeach
        <div class="clearfix"></div>
    </div>
</div>

<div class="form-group col-sm-6" id="assemblym_div">
    <div class="the-box bg-success no-border">
        <h4 class="small-title">GABINETES</h4>
        @foreach($assemblyman as $value)
            <div class="col-sm-2">
                {!! Form::checkbox('assemblyman[]',$value->id, in_array($value->id, $user_assemblyman) ? true : false) !!}
                {{ $value->short_name }}
            </div>
        @endforeach
        <div class="clearfix"></div>
    </div>
</div>

<!--- Submit Field --->
<div class="form-group col-sm-12">
    {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
</div>
<script>

    $(document).ready(function(){

        $('#assemblym_div').hide();

        if($('#sector_id').val() == '2'){
            $('#assemblym_div').show();
        }
        else{
            $('#assemblym_div').hide();
        }

        $('#sector_id').change(function(){
            if(this.value == 2){
                $('#assemblym_div').show();
            } else {
                $('#assemblym_div').hide();
            }
        });

    });
</script>
