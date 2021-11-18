<!-- Companies Id Field -->
<div class="form-group col-sm-6" style="display:none">
    {!! Form::label('companies_id', 'Companies Id:') !!}
    {!! Form::text('companies_id', Auth::user()->company->id, ['class' => 'form-control']) !!}
</div>

<!-- From Field -->
<div class="form-group col-sm-6">
    {!! Form::label('from', 'De:', ['class' => 'required']) !!}
    {!! Form::text('from', null, ['class' => 'form-control datepicker', 'minlength' => '10']) !!}
</div>

<!-- To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('to', 'Até:', ['class' => 'required']) !!}
    {!! Form::text('to', null, ['class' => 'form-control datepicker', 'minlength' => '10']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('legislatures.index') !!}" class="btn btn-default">Cancelar</a>
</div>
