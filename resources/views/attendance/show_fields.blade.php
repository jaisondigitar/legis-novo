<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $attendance->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $attendance->people->name !!}</p>
</div>

<!-- Date Start Field -->
<div class="form-group">
    {!! Form::label('date', 'Data:') !!}
    <p>{!! $attendance->date !!}</p>
</div>

<!-- Date End Field -->
<div class="form-group">
    {!! Form::label('time', 'Hora:') !!}
    <p>{!! $attendance->time !!}</p>
</div>

<!-- Type End Field -->
<div class="form-group">
    {!! Form::label('time', 'Tipo de Atendimento:') !!}
    <p>{!! $attendance->type->name !!}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $attendance->description !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $attendance->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $attendance->updated_at !!}</p>
</div>
