<!-- Name Field -->
<div class="form-group col-sm-2">
    {!! Form::label('parent_id', 'Filho de:') !!}
    {!! Form::select('parent_id', \App\Models\DocumentType::where('parent_id',0)->pluck('name','id')->prepend('Selecione...', 0),null, ['class' => 'form-control']) !!}
</div>
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Prefix Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prefix', 'Prefixo:') !!}
    {!! Form::text('prefix', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('documentTypes.index') !!}" class="btn btn-default">Cancelar</a>
</div>
