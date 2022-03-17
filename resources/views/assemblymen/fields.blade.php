    <!-- Companies Id Field -->
    <div class="row">
        <div class="col-6">
            <h2>Cadastro</h2>
            <div class="row">
                <div class="form-group col-sm-6" style="display:none">
                    {!! Form::label('companies_id', 'Companies Id:') !!}
                    {!! Form::text('companies_id', Auth::user()->company->id, ['class' => 'form-control']) !!}
                </div>

                <!-- Short Name Field -->
                <div class="form-group col-sm-4">
                    {!! Form::label('short_name', 'Nome Parlamentar:', ['class' => 'required']) !!}
                    {!! Form::text('short_name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Full Name Field -->
                <div class="form-group col-sm-8">
                    {!! Form::label('full_name', 'Nome Completo:') !!}
                    {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Email Field -->
                <div class="form-group col-sm-4 mt-2">
                    {!! Form::label('email', 'E-mail:', ['class' => 'required']) !!}
                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Phone1 Field -->
                <div class="form-group col-sm-2 mt-2">
                    {!! Form::label('phone1', 'Celular:') !!}
                    {!! Form::text('phone1', null, ['class' => 'form-control phone']) !!}
                </div>

                <!-- Phone2 Field -->
                <div class="form-group col-sm-2 mt-2">
                    {!! Form::label('phone2', 'Telefone:') !!}
                    {!! Form::text('phone2', null, ['class' => 'form-control phone']) !!}
                </div>

                <!-- Official Document Field -->
                <div class="form-group col-sm-2 mt-2">
                    {!! Form::label('official_document', 'CPF:') !!}
                    {!! Form::text('official_document', null, ['class' => 'form-control cpf']) !!}
                </div>

                <!-- General Register Field -->
                <div class="form-group col-sm-2 mt-2">
                    {!! Form::label('general_register', 'RG:') !!}
                    {!! Form::number('general_register', null, ['class' => 'form-control', 'min' => 1000000, 'max' => 999999999]) !!}
                </div>
            </div>
        </div>


            <div class="col-6">
                <div class="row">
                    <h2>Associações</h2>
                    <div class="col-sm-2">
                        {!! Form::label('legislature_id', 'Legislatura:', ['class' => 'small-title required']) !!}
                        {!! Form::select('legislature_id', $selectLegislature, null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-sm-2">
                    {!! Form::label('party_id', 'Partidos:', ['class' => 'small-title required']) !!}
                    {!! Form::select('party_id', $parties, null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-sm-2">
                    {!! Form::label('party_date', 'Data:') !!}
                    {!! Form::text('party_date', isset($assemblyman) ? null : \Carbon\Carbon::now()->format('d/m/Y'),['class' => 'form-control datepicker']) !!}
                    </div>

                    <div class="col-sm-2">
                        {!! Form::label('responsibility_id', 'Responsabilidade:', ['class' => 'small-title required']) !!}
                        {!! Form::select('responsibility_id', $responsibility, null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-sm-2">
                        {!! Form::label('responsibility_date', 'Data:') !!}
                        {!! Form::text('responsibility_date', isset($assemblyman) ? null : \Carbon\Carbon::now()->format('d/m/Y'), ['class' => 'form-control datepicker']) !!}
                    </div>
                </div>
            </div>

            <h4 class="mt-2">Endereço</h4>
                <!-- Zipcode Field -->
                <div class="form-group col-sm-2">
                    {!! Form::label('zipcode', 'CEP:') !!}
                    {!! Form::text('zipcode', null, ['class' => 'form-control cep']) !!}
                </div>
                <!-- Street Field -->
                <div class="form-group col-sm-5">
                    {!! Form::label('street', 'Rua:') !!}
                    {!! Form::text('street', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Number Field -->
                <div class="form-group col-sm-2">
                    {!! Form::label('number', 'Número:') !!}
                    {!! Form::text('number', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Complement Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('complement', 'Complemento:') !!}
                    {!! Form::text('complement', null, ['class' => 'form-control']) !!}
                </div>

                <!-- District Field -->
                <div class="form-group col-sm-6 mt-2">
                    {!! Form::label('district', 'Bairro:') !!}
                    {!! Form::text('district', null, ['class' => 'form-control']) !!}
                </div>
                <!-- State Id Field -->
                <div class="form-group col-sm-2 mt-2">
                    {!! Form::label('state_id', 'Estado') !!}
                    {!! Form::select('state_id', $states, null, ['class' => 'form-control states', 'onChange'=>'getCities(\'state_id\')']) !!}
                </div>

                <!-- City Id Field -->
                <div class="form-group col-sm-4 mt-2">
                    {!! Form::label('city_id', 'Cidade:') !!}
                    {!! Form::select('city_id', $cities, null, ['class' => 'form-control cities']) !!}
                </div>
                <div class="form-group col-sm-4">
                    @if(isset($assemblyman) && !empty($assemblyman->image))
                        <div class="logo-inst">
                            <img
                                src="{{ (new \App\Services\StorageService())->inAssemblymanFolder()
                                ->getPath($assemblyman->image) }}"
                                class="img-thumbnail img-rounded"
                            >
                            <div style="width: 100px;padding: 5px;font-family: monospace;">
                                <a href="#" onclick="removeImage()"><i class="fa fa-remove"></i> Remover</a>
                            </div>
                        </div>
                    @endif
                    <div
                        class="upload mt-2"
                        @if(isset($assemblyman) && !empty($assemblyman->image))
                            style="display: none;"
                        @endif
                    >
                        {!! Form::label('image', " Foto:") !!}
                        {!! Form::file('image', ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-2">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
            <a href="{!! route('assemblymen.index') !!}" class="btn btn-default">Cancelar</a>
        </div>

@if(isset($assemblyman) && !empty($assemblyman->image))
    <script>
        const removeImage = function(){
            const url = '/assemblymen/{{ $assemblyman->id }}/delimage';
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
