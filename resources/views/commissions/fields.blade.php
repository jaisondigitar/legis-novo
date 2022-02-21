<!-- Date Start Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_start', 'Data início:', ['class' => 'required']) !!}
    {!! Form::text('date_start', null, ['class' => 'form-control datepicker', 'required']) !!}
</div>

<!-- Date End Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_end', 'Data encerramento:', ['class' => 'required']) !!}
    {!! Form::text('date_end', null, ['class' => 'form-control datepicker', 'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Descrição:', ['class' => 'required']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control ckeditor']) !!}
</div>
<div class="form-group col-sm-12">
    <div style="height: 300px; overflow-y: auto;">
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Parlamentares</th>
                <th>Cargos</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="tbody" >

        </tbody>
    </table>
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-12">
    <button class="btn btn-info" type="button" id="addAssemblymanBtn">Adicionar Parlamentar</button>
</div>

<div id="addAssemblymanDiv">
    <div class="form-group col-sm-6">
        {!! Form::label('assemblyman', 'Parlamentar:') !!}
        {!! Form::select(null, $assemblymen, null, ['class' => 'form-control', 'id' => 'assemblyman_id' ]) !!}
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('office', 'Cargo:') !!}
        {!! Form::select(null, $office_commission, null, ['class' => 'form-control', 'id' => 'office']) !!}
    </div>
    <!-- Date Start Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('start_date', 'Data início:') !!}
        {!! Form::text('start_date', null, ['class' => 'form-control datepicker']) !!}
    </div>

    <!-- Date End Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('end_date', 'Data encerramento:') !!}
        {!! Form::text('end_date', null, ['class' => 'form-control datepicker']) !!}
    </div>
    <div class="form-group col-sm-12">
        <button class="btn btn-info pull-right" type="button" id="saveAssemblymanBtn">Salvar Parlamentar</button>
    </div>
</div>

<div class="hidden" id="assemblyman_commission_hidden">

</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('commissions.index') !!}" class="btn btn-default">Cancelar</a>
</div>

<script>
    $(document).ready( function () {

        $('#addAssemblymanDiv').hide();

        var listAssemblyman = [];

        var commission_id = "{{ isset($commission) ? $commission->id : '' }}";

        $.ajax({
            method: "GET",
            url: "{{ url('commission-assemblymen') }}/"+ commission_id,
            dataType: "json"
        }).success(function (result) {
            $.each(result, function( index, value ) {
                //Adicionando a visualização
                $('#tbody').append('<tr id="show'+value.assemblyman_id+ '">' +
                    '<td>'+ value.assemblyman.full_name +'</td>' +
                    '<td>'+ value.office_commission.name +'</td>' +
                    '<td>' + value.start_date + '</td>' +
                    '<td>'+ value.end_date +'</td>'+
                    '<td>' +
                    '<button type="button" onclick="removeAssemblyman('+ value.office +','+ value.assemblyman_id+')" class="btn btn-sm btn-danger">' +
                    '<i class="glyphicon glyphicon-remove"></i>' +
                    '</button>' +
                    '</td></tr>');
                // extra button <button class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></button>

                //Adicionando hidden
                var inputs = '<div data-assemblyman="' + value.assemblyman_id + '" id="hidden'+value.assemblyman_id+ '">';
                inputs += '<input type="hidden" name="assemblyman_comission[' + value.assemblyman_id + '][assemblyman_id]" value="' + value.assemblyman_id + '">';
                inputs += '<input type="hidden" name="assemblyman_comission[' + value.assemblyman_id + '][office_id]" value="' + value.office + '">';
                inputs += '<input type="hidden" name="assemblyman_comission[' + value.assemblyman_id + '][start_date]" value="' + value.start_date + '">';
                inputs += '<input type="hidden" name="assemblyman_comission[' + value.assemblyman_id + '][end_date]" value="' + value.end_date + '">';
                inputs += '</div>';
                $(inputs).appendTo('#assemblyman_commission_hidden');
                var i = value.assemblyman_id;
                var l = value.office;
                $("#assemblyman_id option[value='"+ i +"']").hide();
                $("#office option[value='"+ l +"']").hide();
            });

        });

        $('#addAssemblymanBtn').click( function () {
            $('#addAssemblymanDiv').show();
        });

        $('#saveAssemblymanBtn').click(function () {
            var assemblyman_id = $('#assemblyman_id').val();
            var assemblyman_text = $("#assemblyman_id option:selected").text();
            var office_id = $('#office').val();
            var office_text = $('#office option:selected').text();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            // Limpar e remover selecionados
            $("#assemblyman_id option:selected").hide();
            $("#office option:selected").hide();
            $('#assemblyman_id').val('');
            $('#office').val('');
            $('#start_date').datepicker('setDate', null);
            $('#end_date').datepicker('setDate', null);


            $('#addAssemblymanDiv').hide();

            listAssemblyman.push({
                assemblyman_id : assemblyman_id,
                office_id : office_id,
                start_date : start_date,
                end_date : end_date
            });

            $('#commission_assemblyman').val(JSON.stringify(listAssemblyman));

            //Adicionando a visualização
            $('#tbody').append('<tr id="show'+assemblyman_id+ '">' +
                '<td>'+ assemblyman_text +'</td>' +
                '<td>'+ office_text +'</td>' +
                '<td>'+ start_date +'</td>' +
                '<td>'+ end_date +'</td>' +
                '<td>' +
                '<button type="button" class="btn btn-sm btn-danger" onclick="removeAssemblyman('+ office_id +','+ assemblyman_id +')"><i class="glyphicon glyphicon-remove"></i></button>' +
                '</td>' +
                '</tr>');

            //Adicionando hidden
            var inputs = '<div data-assemblyman="' + assemblyman_id + '" id="hidden'+assemblyman_id+ '">';
            inputs += '<input type="hidden" name="assemblyman_comission[' + assemblyman_id + '][assemblyman_id]" value="' + assemblyman_id + '">';
            inputs += '<input type="hidden" name="assemblyman_comission[' + assemblyman_id + '][office_id]"      value="' + office_id + '">';
            inputs += '<input type="hidden" name="assemblyman_comission[' + assemblyman_id + '][start_date]"     value="' + start_date + '">';
            inputs += '<input type="hidden" name="assemblyman_comission[' + assemblyman_id + '][end_date]"       value="' + end_date + '">';
            inputs += '</div>';
            $(inputs).appendTo('#assemblyman_commission_hidden');

        });
    })
    function removeAssemblyman(office_id, assemblyman_id) {
        var r = confirm('Deseja remover o parlamentar?');
        if (r == true) {
            $("#assemblyman_id option[value='"+ assemblyman_id +"']").show();
            $("#office option[value='"+ office_id +"']").show();
            $("#show"+assemblyman_id).remove();
            $("#hidden"+assemblyman_id).remove();
            alert('Excluido com sucesso!');
        }
    }
</script>


