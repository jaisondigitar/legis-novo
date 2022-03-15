    <div class="row">
        <div class="col-6">
            <h2>Dados Pessoais</h2>
            <!-- Cpf Field -->
            <div class="row">
                <div class="form-group col-sm-3">
                    {!! Form::label('cpf', 'CPF:') !!}
                    {!! Form::text('cpf', $people->cpf ?? '', ['class' => 'form-control cpf', 'onChange' => 'getPeople(cpf.value)']) !!}
                </div>

                <!-- Rg Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('rg', 'RG:') !!}
                    {!! Form::text('rg', $people->rg ?? '', ['class' => 'form-control rg']) !!}
                </div>

                <!-- Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
                    {!! Form::text('name', $people->name ?? '', ['class' => 'form-control name', 'style' => 'text-transform: uppercase']) !!}
                </div>

                <!-- Celular Field -->
                <div class="form-group col-sm-4 mt-2">
                    {!! Form::label('celular', 'Celular:', ['class' => 'required']) !!}
                    {!! Form::text('celular', $people->celular ?? '', ['class' => 'form-control phone phone1']) !!}
                </div>

                <!-- Phone2 Field -->
                <div class="form-group col-sm-4 mt-2">
                    {!! Form::label('telephone', 'Telefone:') !!}
                    {!! Form::text('telephone', $people->telephone ?? '', ['class' => 'form-control phone phone2']) !!}
                </div>

                <!-- Email Field -->
                <div class="form-group col-sm-4 mt-2">
                    {!! Form::label('email', 'E-mail:') !!}
                    {!! Form::email('email', $people->email ?? '', ['class' => 'form-control email']) !!}
                </div>

                <!-- Photo Field -->
                <div class="form-group col-sm-12 mt-2">
                    @if(isset($people) && !empty($people->image))
                        <img src="{{ !empty($people->image) && (new \App\Services\StorageService())
                        ->inPeopleFolder()->getPath($people->image) }}" width="150px" class="img-thumbnail
                        img-rounded image">
                        <div style="width: 100px;padding: 5px;font-family: monospace;">
                            <a href="#" onclick="removeImage()"><i class="fa fa-remove"></i> Remover</a>
                        </div>
                    @endif
                    <div class="upload" @if(isset($people) && !empty($people->image)) style="display: none;" @endif >
        {{--                <i class="fa fa-image"></i>--}}
                        {!! Form::label('image', " Foto:") !!}
                        {!! Form::file('image', ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <h2>Endereço</h2>
            <div class="row">
                <!-- Zipcode Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('zipcode', 'CEP:') !!}
                    {!! Form::text('zipcode', $people->zipcode ?? '', ['class' => 'form-control cep']) !!}
                </div>
                <!-- Street Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('street', 'Rua:') !!}
                    {!! Form::text('street', $people->street ?? '', ['class' => 'form-control street']) !!}
                </div>

                <!-- Number Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('number', 'Número:') !!}
                    {!! Form::text('number', $people->number ?? '', ['class' => 'form-control number']) !!}
                </div>

                <!-- District Field -->
                <div class="form-group col-sm-6 mt-2">
                    {!! Form::label('district', 'Bairro:') !!}
                    {!! Form::text('district', $people->district ?? '', ['class' => 'form-control district']) !!}
                </div>

                <!-- Complement Field -->
                <div class="form-group col-sm-6 mt-2">
                    {!! Form::label('complement', 'Complemento:') !!}
                    {!! Form::text('complement', $people->complement ?? '', ['class' => 'form-control complement']) !!}
                </div>

                <!-- State Id Field -->
                <div class="form-group col-sm-4 mt-2">
                    {!! Form::label('state_id', 'Estado:') !!}
                    {!! Form::select('state_id', $states, $people->state_id ?? '', ['class' => 'form-control states', 'onChange'=>'getCities(\'state_id\')']) !!}
                </div>

                <!-- City Id Field -->
                <div class="form-group col-sm-8 mt-2">
                    {!! Form::label('city_id', 'Cidade:') !!}
                    {!! Form::select('city_id', $cities, $people->city_id ?? '', ['class' => 'form-control cities']) !!}
                </div>
            </div>
        </div>

        <h2 class="mt-3">Atendimento</h2>
        <div class="row">
            <div class="col-2">
                <div class="row">
                    <!-- Date Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('date', 'Data:', ['class' => 'required']) !!}
                        {!! Form::text('date', null, ['class' => 'form-control datepicker']) !!}
                    </div>

                    <!-- Time Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('time', 'Hora:', ['class' => 'required']) !!}
                        {!! Form::time('time', null, ['class' => 'form-control time_default']) !!}
                    </div>

                    <!-- Sector Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('sector_id', 'Setor:', ['class' => 'required']) !!}
                        {!! Form::select('sector_id', $sector, null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Type Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('type_id', 'Tipo:', ['class' => 'required']) !!}
                        {!! Form::select('type_id', $type, null, ['class' => 'form-control']) !!}
                    </div>
                    </div>
                </div>
                    <!-- Description Field -->
                    <div class="form-group col-sm-10">
                    {!! Form::label('description', 'Descrição:', ['class' => 'required']) !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4']) !!}
                </div>
                </div>
            </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-3 mt-3">
        {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
        <a href="{!! route('attendance.index') !!}" class="btn btn-default">Cancelar</a>
    </div>

<script>
    document.querySelector('#date').value = dateForm
    document.querySelector('#time').value = timeForm

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
