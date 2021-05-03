<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $log->id !!}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{!! $log->user_id !!}</p>
</div>

<!-- Owner Type Field -->
<div class="form-group">
    {!! Form::label('owner_type', 'Owner Type:') !!}
    <p>{!! $log->owner_type !!}</p>
</div>

<!-- Owner Id Field -->
<div class="form-group">
    {!! Form::label('owner_id', 'Owner Id:') !!}
    <p>{!! $log->owner_id !!}</p>
</div>

<!-- Old Value Field -->
<div class="form-group">
    {!! Form::label('old_value', 'Old Value:') !!}
    <p>{!! $log->old_value !!}</p>
</div>

<!-- New Value Field -->
<div class="form-group">
    {!! Form::label('new_value', 'New Value:') !!}
    <p>{!! $log->new_value !!}</p>
</div>

<!-- Type Field -->
<div class="form-group">
    {!! Form::label('type', 'Type:') !!}
    <p>{!! $log->type !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $log->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $log->updated_at !!}</p>
</div>

