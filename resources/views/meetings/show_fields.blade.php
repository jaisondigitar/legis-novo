<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $meeting->id !!}</p>
</div>

<!-- Session Type Id Field -->
<div class="form-group">
    {!! Form::label('session_type_id', 'Session Type Id:') !!}
    <p>{!! $meeting->session_type_id !!}</p>
</div>

<!-- Session Place Id Field -->
<div class="form-group">
    {!! Form::label('session_place_id', 'Session Place Id:') !!}
    <p>{!! $meeting->session_place_id !!}</p>
</div>

<!-- Date Start Field -->
<div class="form-group">
    {!! Form::label('date_start', 'Date Start:') !!}
    <p>{!! $meeting->date_start !!}</p>
</div>

<!-- Date End Field -->
<div class="form-group">
    {!! Form::label('date_end', 'Date End:') !!}
    <p>{!! $meeting->date_end !!}</p>
</div>

<div class="form-group">
    {!! Form::label('number', 'Number') !!}
    <p>{!! $meeting->number !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $meeting->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $meeting->updated_at !!}</p>
</div>

