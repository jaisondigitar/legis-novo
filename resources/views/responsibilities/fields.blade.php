    <div class="row">
        <!-- Companies Id Field -->
        <div class="form-group col-sm-6" style="display:none">
            {!! Form::label('companies_id', 'Companhia:') !!}
            {!! Form::text('companies_id', Auth::user()->company->id, ['class' => 'form-control']) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Nome:' , ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('order', 'Ordem:' , ['class' => 'required']) !!}
            {!! Form::number('order', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-2">
            {!! Form::label('skip_board', 'Ignora mesa diretora:') !!}
            <div class="clearfix"></div>
            {!! Form::checkbox('skip_board', 1, null, ['class' => 'form-control switch' , 'data-on-text' => 'Sim', 'data-off-text' => 'Não', 'data-off-color' => 'danger', 'data-on-color' => 'success', 'data-size' => 'normal', 'type' => 'checkbox' ]) !!}
        </div>
{{--    criar logica para a checkbox    --}}
        <div  class="col-sm-2 form-group form-check form-switch form-switch-md">
            <input
                style="margin: 1.5rem 0 0 -1rem"
                name="active"
                class="form-check-input"
                type="checkbox"
            >
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
            <a href="{!! route('responsibilities.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
