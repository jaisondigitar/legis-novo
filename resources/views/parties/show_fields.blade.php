<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $party->id !!}</p>
</div>

<!-- Companies Id Field -->
<div class="form-group">
    {!! Form::label('companies_id', 'Companhia:') !!}
    <p>{!! $party->companies_id !!}</p>
</div>

<!-- Prefix Field -->
<div class="form-group">
    {!! Form::label('prefix', 'Sigla:') !!}
    <p>{!! $party->prefix !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nome:') !!}
    <p>{!! $party->name !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $party->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $party->updated_at !!}</p>
</div>

