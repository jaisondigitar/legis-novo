    <div class="row">
        <h2 style="margin: 0">Dados Pessoais</h2><hr style="margin: 20px 0">
        <!-- Cpf Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('cpf', 'CPF:') !!}
            {!! Form::text('cpf', null, ['class' => 'form-control cpf']) !!}
        </div>

        <!-- Rg Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('rg', 'RG:') !!}
            {!! Form::text('rg', null, ['class' => 'form-control rg']) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control name', 'style' => 'text-transform: uppercase']) !!}
        </div>

        <!-- Celular Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('celular', 'Celular:', ['class' => 'required']) !!}
            {!! Form::text('celular', null, ['class' => 'form-control phone']) !!}
        </div>

        <!-- Phone2 Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('telephone', 'Telefone:') !!}
            {!! Form::text('telephone', null, ['class' => 'form-control phone']) !!}
        </div>

        <!-- Email Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('email', 'E-mail:') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Photo Field -->
        <div class="form-group col-sm-6">
            @if(isset($people) && !empty($people->image))
                <div class="logo-inst">
                    <img src="{{ (new \App\Services\StorageService())->inPeopleFolder()->getPath
                    ($people->image) }}" width="150px" class="img-thumbnail img-rounded">
                    <div style="width: 100px;padding: 5px;font-family: monospace;">
                        <a href="#" onclick="removeImage()"> Remover</a>
                    </div>
                </div>
            @endif
            <div class="upload" @if(isset($people) &&  !empty($people->image)) style="display: none;" @endif >
{{--                <i class="fa fa-image"></i>--}}
                {!! Form::label('image', " Foto:") !!}
                {!! Form::file('image', ['class' => 'form-control']) !!}
            </div>
        </div>

        <h2 class="mt-3" style="margin: 0">Endereço</h2><hr style="margin: 20px 0">
        <!-- Zipcode Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('zipcode', 'CEP:') !!}
            {!! Form::text('zipcode', null, ['class' => 'form-control cep']) !!}
        </div>
        <!-- Street Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('street', 'Rua:') !!}
            {!! Form::text('street', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Number Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('number', 'Número:') !!}
            {!! Form::text('number', null, ['class' => 'form-control']) !!}
        </div>

        <!-- District Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('district', 'Bairro:') !!}
            {!! Form::text('district', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Complement Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('complement', 'Complemento:') !!}
            {!! Form::text('complement', null, ['class' => 'form-control']) !!}
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
        <!-- Submit Field -->
        <div class="form-group col-sm-3 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
            <a href="{!! route('people.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>

@if(isset($people) && !empty($people->image))
    <script>
        const removeImage = function(){
            const url = '/people/{{ $people->id }}/delimage';
            $.ajax({
                method: "GET",
                url: url,
                dataType: "json"
            }).success(function(result) {
                if(result){
                    $(".logo-inst").fadeOut(300,function(){
                        $(".upload").fadeIn(300);
                    });
                }else{
                    toastr["warning"]("Falha ao apagar imagem.","Ops!");
                }
            });
        }
    </script>
@endif
