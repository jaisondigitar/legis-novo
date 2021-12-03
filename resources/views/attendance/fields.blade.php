<div class="form-group col-sm-12">
    <div class="form-group col-sm-6">
        <h2 style="margin: 0">Dados Pessoais</h2><hr style="margin: 20px 0">
        <!-- Cpf Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('cpf', 'CPF:', ['class' => 'required']) !!}
            {!! Form::text('cpf', null, ['class' => 'form-control cpf', 'onChange' => 'getPeople(cpf.value)']) !!}
        </div>

        <!-- Celular Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('celular', 'Celular:', ['class' => 'required']) !!}
            {!! Form::text('celular', null, ['class' => 'form-control phone']) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control name']) !!}
        </div>
    </div>

    <div class="form-group col-sm-6">
        <h2 style="margin: 0">Endereço</h2><hr style="margin: 20px 0">
        <!-- Zipcode Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('zipcode', 'CEP:') !!}
            {!! Form::text('zipcode', null, ['class' => 'form-control cep']) !!}
        </div>
        <!-- Street Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('street', 'Rua:') !!}
            {!! Form::text('street', null, ['class' => 'form-control street']) !!}
        </div>

        <!-- Number Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('number', 'Número:') !!}
            {!! Form::text('number', null, ['class' => 'form-control number']) !!}
        </div>

        <!-- District Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('district', 'Bairro:') !!}
            {!! Form::text('district', null, ['class' => 'form-control district']) !!}
        </div>

        <!-- Complement Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('complement', 'Complemento:') !!}
            {!! Form::text('complement', null, ['class' => 'form-control complement']) !!}
        </div>

        <!-- State Id Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('state_id', 'Estado:') !!}
            {!! Form::select('state_id', $states, null, ['class' => 'form-control states', 'onChange'=>'getCities(\'state_id\')']) !!}
        </div>

        <!-- City Id Field -->
        <div class="form-group col-sm-8">
            {!! Form::label('city_id', 'Cidade:') !!}
            {!! Form::select('city_id', $cities, null, ['class' => 'form-control cities']) !!}
        </div>
    </div>
</div>

<div class="form-group col-sm-12">
    <h2 style="margin: 0">Atendimento</h2><hr style="margin: 20px 0">
    <div class="form-group col-sm-3">
        <!-- Date Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('date', 'Data:', ['class' => 'required']) !!}
            {!! Form::date('date', null, ['class' => 'form-control date']) !!}
        </div>

        <!-- Time Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('time', 'Hora:', ['class' => 'required']) !!}
            {!! Form::time('time', null, ['class' => 'form-control time']) !!}
        </div>

        <!-- Type Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('type_id', 'Tipo:', ['class' => 'required']) !!}
            {!! Form::select('type_id', $type, null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <!-- Description Field -->
    <div class="form-group col-sm-9">
        {!! Form::label('description', 'Descrição:', ['class' => 'required']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '8']) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-3">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('attendance.index') !!}" class="btn btn-default">Cancelar</a>
</div>

<script>
    const getDate = (number) => {
        if (number <= 9)
            return "0" + number;
        else
            return number;
    }
    let date = new Date();
    let dateForm = (date.getFullYear() + "-" + (getDate(date.getMonth()+1).toString()) + "-" + getDate(date.getDate().toString()));
    let TimeForm = (getDate(date.getHours()) + ":" + getDate(date.getMinutes()));
    document.querySelector('.date').value = dateForm
    document.querySelector('.time').value = TimeForm
</script>
