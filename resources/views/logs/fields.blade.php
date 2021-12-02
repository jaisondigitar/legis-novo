<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::number('id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auditable_type', 'Owner Type:') !!}
    {!! Form::text('auditable_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auditable_id', 'Owner Id:') !!}
    {!! Form::number('auditable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Old Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('old_values', 'Old Value:') !!}
    {!! Form::textarea('old_values', null, ['class' => 'form-control']) !!}
</div>

<!-- New Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('new_values', 'New Value:') !!}
    {!! Form::textarea('new_values', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('event', 'Type:') !!}
    {!! Form::text('event', null, ['class' => 'form-control']) !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    {!! Form::date('created_at', null, ['class' => 'form-control']) !!}
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Updated At:') !!}
    {!! Form::date('updated_at', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('logs.index') !!}" class="btn btn-default">Cancel</a>
</div>
