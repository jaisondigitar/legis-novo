<!-- Name Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $module->name !!}</p>
</div>

<!-- Token Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('token', 'Token:') !!}
    <p>{!! $module->token !!}</p>
</div>

<!-- Active Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('active', 'Active:') !!}
    <p>{!! $module->active !!}</p>
</div>

