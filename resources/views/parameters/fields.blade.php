<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Type Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('type', 'Tipo:', ['class' => 'required']) !!}
        {!! Form::select('type',[''=> 'Selecione', 1 => 'CheckBox', 2 => 'Input'], null, ['class' => 'form-control', 'required', 'id' => 'selectType']) !!}
    </div>


    <div class="form-group col-sm-3" id="divText">
        {!! Form::label('value', 'Valor:', ['class' => 'required']) !!}
        {!! Form::text('valueText', (isset($parameters) && $parameters->type == 2) ? $parameters->value : null, ['class' => 'form-control']) !!}
    </div>




    <div class="form-group col-sm-3" id="divSelect">
        {!! Form::label('value', 'Valor:', ['class' => 'required']) !!}
        {!! Form::select('valueSelect',[ 0 => 'Não', 1 => 'Sim'], (isset($parameters) && $parameters->type == 1) ? $parameters->value : null, ['class' => 'form-control']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12 mt-3">
        {!! Form::submit('Salvar', ['class' => 'btn btn-success btn-sm']) !!}
        <a href="{!! route('parameters.index') !!}" class="btn btn-default btn-sm">Cancelar</a>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#divText').hide();
        $('#divSelect').hide();

        if($('#selectType').val() == 1){
            $('#divText').hide();
            $('#divSelect').show();

        } else if ($('#selectType').val() == 2) {
            $('#divText').show();
            $('#divSelect').hide();
        } else {
            $('#divText').hide();
            $('#divSelect').hide();
        }

        $('#selectType').change(function () {
            if(this.value == 1){
                $('#divText').hide();
                $('#divSelect').show();

            } else if (this.value == 2) {
                $('#divText').show();
                $('#divSelect').hide();
            } else {
                $('#divText').hide();
                $('#divSelect').hide();
            }
        })

    })
</script>
