<!-- Id Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $permission->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $permission->name !!}</p>
</div>

<!-- Readable Name Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('readable_name', 'Readable Name:') !!}
    <p>{!! $permission->readable_name !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $permission->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $permission->updated_at !!}</p>
</div>

