<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $documentType->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nome:') !!}
    <p>{!! $documentType->name !!}</p>
</div>

<!-- Prefix Field -->
<div class="form-group">
    {!! Form::label('prefix', 'Prefixo:') !!}
    <p>{!! $documentType->prefix !!}</p>
</div>

<!-- Slug Field -->
<div class="form-group">
    {!! Form::label('slug', 'Sigla:') !!}
    <p>{!! $documentType->slug !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $documentType->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $documentType->updated_at !!}</p>
</div>

