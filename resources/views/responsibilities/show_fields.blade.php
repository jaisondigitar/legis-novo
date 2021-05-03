<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $responsibility->id !!}</p>
</div>

<!-- Companies Id Field -->
<div class="form-group">
    {!! Form::label('companies_id', 'Companhia:') !!}
    <p>{!! $responsibility->companies_id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nome:') !!}
    <p>{!! $responsibility->name !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $responsibility->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $responsibility->updated_at !!}</p>
</div>

