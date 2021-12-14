<div class="form-group col-sm-12">
    <div class="form-group col-sm-6">
        <h2 style="margin: 0">Dados Pessoais</h2><hr style="margin: 20px 0">
        <!-- Cpf Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('cpf', 'CPF:', ['class' => 'required']) !!}
            {!! Form::text('cpf', null, ['class' => 'form-control cpf', 'onChange' => 'getPeople(cpf.value)']) !!}
        </div>

        <!-- Rg Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('rg', 'RG:') !!}
            {!! Form::number('rg', null, ['class' => 'form-control rg', 'min' => 1000000, 'max' => 999999999]) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control name']) !!}
        </div>

        <!-- Celular Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('celular', 'Celular:', ['class' => 'required']) !!}
            {!! Form::text('celular', null, ['class' => 'form-control phone phone1']) !!}
        </div>

        <!-- Phone2 Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('telephone', 'Telefone:') !!}
            {!! Form::text('telephone', null, ['class' => 'form-control phone phone2']) !!}
        </div>

        <!-- Email Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('email', 'E-mail:') !!}
            {!! Form::email('email', null, ['class' => 'form-control email']) !!}
        </div>

        <!-- Photo Field -->
        <div class="form-group col-sm-6">
            <div class="logo-inst" @if(!isset($people)) style="display: none;" @endif>
                <img src="{{ !empty($people->image) && (new \App\Services\StorageService())
                ->inPeopleFolder()->getPath($people->image) }}" width="150px" class="img-thumbnail
                img-rounded image">
                <div style="width: 100px;padding: 5px;font-family: monospace;">
                    <a href="#" onclick="removeImage()"><i class="fa fa-remove"></i> Remover</a>
                </div>
            </div>
            <div class="upload" @if(isset($people) && !empty($people->image)) style="display: none;" @endif >
                <i class="fa fa-image"></i>
                {!! Form::label('image', " Foto:") !!}
                {!! Form::file('image', ['class' => 'form-control']) !!}
            </div>
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

    const removeImage = async () => {
        const peopleId = document.querySelector('.logo-inst img').getAttribute('id')
        const resp = await fetch(`/people/remove-image?people_id=${peopleId}`, {
            headers: { 'X-CSRF-Token': '{!! csrf_token() !!}' },
            method: 'POST'
        })
        console.log(resp)
        if (resp.status === 200) {
            $(".logo-inst").fadeOut(300, () => $(".upload").fadeIn(300))
        } else {
            toastr["warning"]("Falha ao apagar imagem.", "Ops!");
        }
    }
</script>
