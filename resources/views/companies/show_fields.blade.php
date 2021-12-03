<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('image', 'Image:') !!}
    <p>
        @if(isset($company) && !empty($company->image))
            <img src="{{ (new \App\Services\StorageService())->inCompanyFolder()->get($company->image) }}" height="150">
        @else
            <i class="fa fa-image"></i>
        @endif
    </p>
</div>

<!-- Shortname Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('shortName', 'Nome Fantasia:') !!}
    <p>{!! $company->shortName !!}</p>
</div>

<!-- Fullname Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('fullName', 'Razão Social:') !!}
    <p>{!! $company->fullName !!}</p>
</div>

<!-- Email Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $company->email !!}</p>
</div>

<!-- Phone1 Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('phone1', 'Telefone 1:') !!}
    <p>{!! $company->phone1 !!}</p>
</div>

<!-- Phone2 Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('phone2', 'Telefone 2:') !!}
    <p>{!! $company->phone2 !!}</p>
</div>

<!-- Mayor Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('mayor', 'Responsável:') !!}
    <p>{!! $company->mayor !!}</p>
</div>

<!-- Cnpjcpf Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('cnpjCpf', 'Cnpj/cpf:') !!}
    <p>{!! $company->cnpjCpf !!}</p>
</div>

<!-- Ierg Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('ieRg', 'Insc. Estadual:') !!}
    <p>{!! $company->ieRg !!}</p>
</div>

<!-- Im Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('im', 'Inscrição Municipal:') !!}
    <p>{!! $company->im !!}</p>
</div>

<!-- City Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('city', 'Cidade:') !!}
    <p>{!! $company->getCity->name !!}/{!! $company->getState->uf !!}</p>
</div>

<!-- Active Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('active', 'Ativo:') !!}
    <input class="switch" onchange="changeStatus('{!! $company->id !!}')" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal" type="checkbox" {!! $company->active>0?'checked':'' !!}>
</div>

<script>
    var changeStatus = function(id){
        var url = '/config/companies/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
            console.log(result);
        });
    }
</script>

