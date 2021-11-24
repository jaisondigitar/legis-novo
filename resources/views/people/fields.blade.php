<div class="form-group col-sm-12">
    <div class="form-group col-sm-6">
        <h2>Dados Pessoais</h2><hr>
        <!-- Cpf Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('cpf', 'CPF:', ['class' => 'required']) !!}
            {!! Form::text('cpf', null, ['class' => 'form-control cpf']) !!}
        </div>

        <!-- Rg Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('rg', 'RG:') !!}
            {!! Form::number('rg', null, ['class' => 'form-control', 'min' => 1000000, 'max' => 999999999]) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Celular Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('celular', 'Celular:', ['class' => 'required']) !!}
            {!! Form::text('celular', null, ['class' => 'form-control phone']) !!}
        </div>

        <!-- Phone2 Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('telephone', 'Telefone 2:') !!}
            {!! Form::text('telephone', null, ['class' => 'form-control phone']) !!}
        </div>

        <!-- Email Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('email', 'E-mail:') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Photo Field -->
        <div class="form-group col-sm-6">
            @if(isset($assemblyman) && is_file(base_path()."/public".$assemblyman->image))
                <div class="logo-inst">
                    <img src="{{ $assemblyman->image }}" class="img-thumbnail img-rounded">
                    <div style="width: 100px;padding: 5px;font-family: monospace;">
                        <a href="#" onclick="removeImage()"><i class="fa fa-remove"></i> Remover</a>
                    </div>
                </div>
            @endif
            <div class="upload" @if(isset($assemblyman) && is_file(base_path()."/public".$assemblyman->image)) style="display: none;" @endif >
                <i class="fa fa-image"></i>
                {!! Form::label('image', " Foto:") !!}
                {!! Form::file('image', ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-group col-sm-6">
        <h2>Endereço</h2><hr>
        <!-- Zipcode Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('zipcode', 'CEP:', ['class' => 'required']) !!}
            {!! Form::text('zipcode', null, ['class' => 'form-control cep']) !!}
        </div>
        <!-- Street Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('street', 'Rua:') !!}
            {!! Form::text('street', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Number Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('number', 'Número:', ['class' => 'required']) !!}
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
            {!! Form::label('state_id', 'Estado:', ['class' => 'required']) !!}
            {!! Form::select('state_id', $states, null, ['class' => 'form-control states', 'onChange'=>'getCities(\'state_id\')']) !!}
        </div>

        <!-- City Id Field -->
        <div class="form-group col-sm-8">
            {!! Form::label('city_id', 'Cidade:', ['class' => 'required']) !!}
            {!! Form::select('city_id', $cities, null, ['class' => 'form-control cities']) !!}
        </div>
    </div>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-3">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('people.index') !!}" class="btn btn-default">Cancelar</a>
</div>

@if(isset($assemblyman) && is_file(base_path()."/public".$assemblyman->image))
    <script>
        var removeImage = function(){
            var url = '/people/{{ $assemblyman->id }}/delimage';
            $.ajax({
                method: "GET",
                url: url,
                dataType: "json"
            }).success(function(result,textStatus,jqXHR) {
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
