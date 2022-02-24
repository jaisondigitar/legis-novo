<style>
    h1 {
        margin-left: 50px;
    }

    .container {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 20px;
    }

    .container:before {
        display: none;
    }

    .action{
        float: right;
    }

    .action a {
        margin-right: 4px;
    }
</style>

@foreach($lawsProjects as $lawsProject)
    @if (Auth::user()->can_request_legal_option_not_root && isset($lawsProject->advices->last()->legal_option))
    @else
        <div class="col-lg-6">
            @include('lawsProjects.card')
        </div>
    @endif
@endforeach
{{--MODAL VOTAÇÃO--}}


{!! $lawsProjects->appends(request()->input())->render() !!}
<div id="answer" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Responder Projeto de Lei</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="document_id" id="document_id">
                <input type="hidden" name="next_number_origin" id="next_number_origin">

                <div class="form-group col-sm-12">
                    <label>
                        Descrição:
                        <textarea
                            name="comissionDescriprion"
                            id="comissionDescriprion"
                            class="form-control descricao ckeditor"
                        ></textarea>
                    </label>
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::label('file[]', 'Anexo de Resposta:') !!}
                    {!! Form::file('file[]', array('multiple'=>true, 'class' => 'file')) !!}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                <button type="button" id="save-reply" class="btn btn-success pull-right">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalApproved" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Aprovar lei</h4>
            </div>
            <div class="modal-body">
                <div align="center"><label class="label label-danger" id="labelmessage"></label></div>
                <input type="hidden" name="law_project_id" id="law_project_id">
                <div class="form-group col-sm-12">
                    {!! Form::label('law_place_id', 'Local de publicação') !!}
                    {!! Form::select('law_place_id', $law_places, null, ['class' => 'form-control', 'id' => 'law_place_id' , 'required']) !!}
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('law_number', 'Número lei oficial:') !!}
                    {!! Form::text('law_number', null, ['class' => 'form-control', 'id' => 'law_number']) !!}
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('date_publish', 'Data de publicação:') !!}
                    {!! Form::text('date_publish', null, ['class' => 'form-control datepicker', 'id' => 'date_publish']) !!}
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('year_law', 'Ano lei oficial:') !!}
                    {!! Form::text('year_law', null, ['class' => 'form-control', 'id' => 'year_law', 'readonly']) !!}
                    <label class="label label-info">*Campo não pode ser alterado.</label>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success pull-right" id="btn-save-law">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalApprovedEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar lei</h4>
            </div>
            <div class="modal-body">
                <div align="center"><label class="label label-danger" id="labelmessageedit"></label></div>
                <input type="hidden" name="law_project_id" id="law_project_id">
                <div class="form-group col-sm-12">
                    {!! Form::label('law_number_edit', 'Número lei oficial:') !!}
                    {!! Form::text('law_number_edit', null, ['class' => 'form-control', 'id' => 'law_number_edit']) !!}
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('date_publish_edit', 'Data de publicação:') !!}
                    {!! Form::text('date_publish_edit', null, ['class' => 'form-control datepicker', 'id' => 'date_publish_edit']) !!}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success pull-right" id="btn-edit-law">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalProtocol" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Protocolo de lei</h4>
            </div>
            <div class="modal-body">
                <div align="center"><label class="label label-danger" id="labelmessage2"></label></div>
                <input type="hidden" name="law_project_id" id="law_project_protocol_id">
                <div class="form-group col-sm-3">
                    {!! Form::label('date_protocol', 'Data:') !!}
                    {!! Form::text('date_protocol', null, ['class' => 'form-control datepicker', 'id' => 'date_protocol']) !!}
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('project_number', 'Número projeto de lei:') !!}
                    {!! Form::text('project_number', null, ['class' => 'form-control', 'id' => 'project_number', 'disabled']) !!}
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('protocol', 'Protocolo:') !!}
                    {!! Form::text('protocol', null, ['class' => 'form-control', 'id' => 'protocol', $externo]) !!}
                    <label class="label label-info">*Campo não pode ser alterado.</label>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success pull-right" id="btn-save-protocol">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalProtocolEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alterar - número / protocolo</h4>
            </div>
            <div class="modal-body">
                <div align="center"><label class="label label-danger" id="labelmessage2"></label></div>
                <input type="hidden" name="law_project_id" id="law_project_protocol_id_edit">

                @shield('lawsProject.editnumerolei')
                    <div class="form-group col-sm-12">
                        {!! Form::label('project_number_edit', 'Número projeto de lei:') !!}
                        {!! Form::text('project_number_edit', null, ['class' => 'form-control', 'id' => 'project_number_edit', 'disabled']) !!}
                    </div>
                @endshield

                <div class="form-group col-sm-4">
                    {!! Form::label('date_protocol', 'Data do protocolo:') !!}
                    {!! Form::text('date_protocol', null, ['class' => 'form-control datepicker', 'id' => 'date_protocol_edit']) !!}
                </div>

                @shield('lawsProject.editprotocollei')
                <div class="form-group col-sm-8">
                    {!! Form::label('protocol_edit', 'Protocolo:') !!}
                    {!! Form::text('protocol_edit', null, ['class' => 'form-control', 'id' => 'protocol_edit']) !!}
                </div>
                @else
                    <div class="form-group col-sm-8">
                        {!! Form::label('protocol_edit', 'Protocolo:') !!}
                        {!! Form::text('protocol_edit', null, ['class' => 'form-control', 'id' => 'protocol_edit']) !!}
                        <label class="label label-info">*Sem permissão para alterar.</label>
                    </div>
                @endshield
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success pull-right" onclick="editNumberProtocolSave()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const answer = (id) => {
        $('#answer #save-reply').attr('value', id);
        $('#answer').modal();
    };


    const toogleApproved = function (id) {

        url = '/lawproject/' + id + '/toogleApproved';

        data = {
            town_hall : $('#town_hall'+id).is(':checked'),
            _token : '{{csrf_token()}}'
        }

        $.ajax({
            url : url,
            data : data,
            method : 'POST'
        }).success(function (res) {
            res = JSON.parse(res);
            if(res){
                toastr.success("Registro alterado com sucesso!");
            }else{
                toastr.error("Falha ao alterar registro!");
            }
        })
    }

    const approvedEdit = function(id){

        url = '/lawProject-approvedGet';

        data = {
            id : id
        };

        $.ajax({
            url : url,
            data : data,
            method : 'POST'
        }).success(function(data){

            data = JSON.parse(data);

            $('#law_project_id').val(data.id);
            $('#law_number_edit').val(data.law_number);
            $('#date_publish_edit').val(data.law_date);

        });

        $('#modalApprovedEdit').modal('show');
    };

    $("#btn-edit-law").on('click', function(){

        url = '/lawProject-approvedEdit';

        data = {
            law_project_id : $('#law_project_id').val(),
            law_number : $('#law_number_edit').val(),
            law_date_publish : $('#date_publish_edit').val()
        };

        $.ajax({
            url : url,
            data : data,
            method : 'POST',
            dataType : 'json'
        }).success(function(result){
            if(result.success === true){
                console.log('entro');
                $('#tdLawNumber'+result.lawProject_id).html(result.law_number + '/' + result.year);
                $('#tdLawPlace'+result.lawProject_id).html(result.lawProject_place);
                $('#tdLawDate'+result.lawProject_id).html(result.lawProject_date_publish);
                $('#tdLawApproved'+result.lawProject_id).html('<label class="label label-success">Sim</label>');
                $('#tdLawApproved_'+result.lawProject_id).html(result.law_number + ' - ' + result.lawProject_date_publish);
                $('#modalApprovedEdit').modal('hide');
            } else {
                $('#labelmessageedit').html(result.message);
                $('#law_number_edit').val(result.next_number);
            }
        });
    })

    const editNumero = function(id){

        url = '/lawsProject/getNumProt';

        $('#law_project_protocol_id_edit').val(id);

        data = {
            id : id,
            '_token' : '{{csrf_token()}}'
        };

        dados = $.ajax({
            url : url,
            data : data,
            method : 'POST'
        }).success(function(data){

            data = JSON.parse(data);

            if(data) {
                $('#project_number_edit').val(data.project_number);
                $('#protocol_edit').val(data.protocol);
                $('#date_protocol_edit').val(data.protocoldate);
            }
        });

        $('#modalProtocolEdit').modal('show');

    };

    const editNumberProtocolSave = function(){

        url = '/lawsProject/saveProtocolNumber';

        data = {
            id       : $('#law_project_protocol_id_edit').val(),
            number   : $('#project_number_edit').val(),
            protocol : $('#protocol_edit').val(),
            protocoldate : $('#date_protocol_edit').val(),
            '_token' : '{{csrf_token()}}'
        };

        $.ajax({
            url : url,
            data : data,
            method : 'POST'
        }).success(function(result){

            result = JSON.parse(result);

            if(result){
                toastr.success('Dados salvos com sucesso!');
                $('#modalProtocolEdit').modal('hide');
            }else{
                toastr.error('Verifique as informações!');
            }

        });
    };

    const getData = function(){

        const data = new Date();

        const dia = data.getDate() <= 9 ? '0' + data.getDate() : data.getDate() ;
        let mes = data.getMonth() + 1;
        const ano = data.getFullYear();

        mes = mes <= 9 ? '0' + mes : mes;

        return dia + '/' + mes + '/' + ano;
    }

    $(document).ready(function () {
        $('.btn-protocol').on('click', function () {

            const data = getData();

            const id = this.value;
            $.ajax({
                method: "GET",
                url: "{{ url('lawProjectProtocol') }}/"+ id,
                dataType: "json"
            }).success(function (result) {
                console.log(result);
                $('#law_project_protocol_id').val(id);
                $('#project_number').val(result.project_number);
                $('#protocol').val(result.protocol);
                $('#date_protocol').val(data);
                $('#labelmessage2').html('');
                $('#modalProtocol').modal();
            });
        });

        $('#btn-save-protocol').on('click', function () {

            const data = {
                law_project_id: $('#law_project_protocol_id').val(),
                project_number: $('#project_number').val(),
                protocol: $('#protocol').val(),
                protocoldate : $('#date_protocol').val()
            };
            $.ajax({
                method: "POST",
                url: "{{ url('lawsProjectProtocolSave') }}",
                data: data,
                dataType: "json"
            }).success(function (result) {
                if(result.success === true){
                    $('#tdLawProjectNumber'+result.lawProject_id).html(result.project_number + '/' + result.year);
                    $('#tdLawProtocol'+result.lawProject_id).html('<label class="label label-success">Sim</label>');
                    $('#modalProtocol').modal('hide');
                    window.location.reload()
                } else {
                    $('#labelmessage2').html(result.message);
                    $('#project_number').val(result.next_number);
                }
            });
        });

        $('.btn-approved').on('click', function () {
            const id = this.value;
            $.ajax({
                method: "GET",
                url: "{{ url('lawProjectApproved') }}/"+ id,
                dataType: "json"
            }).success(function (result) {
                $('#law_project_id').val(result.data.law_project_id);
                $('#law_number').val(result.data.next_number);
                $('#year_law').val(result.data.year);
                $('#labelmessage').html('');
                $('#modalApproved').modal('show');
            });
        });

        $('#btn-save-law').on('click', function () {
            if($('#law_place_id').val() === '') {
                $('#labelmessage').html('Selecione um local de publicação de protocolo');
            }else if ($('#date_publish').val() === ''){
                $('#labelmessage').html('Inserir a data de publicação');
            } else {
                const data = {
                    law_project_id: $('#law_project_id').val(),
                    law_place_id: $('#law_place_id').val(),
                    law_number: $('#law_number').val(),
                    date_publish: $('#date_publish').val()
                };
                $.ajax({
                    method: "POST",
                    url: "{{ url('lawsProjectApprovedSave') }}",
                    data: data,
                    dataType: "json"
                }).success(function (result) {
                    if(result.success === true){
                        $('#tdLawNumber'+result.lawProject_id).html(result.law_number + '/' + result.year);
                        $('#tdLawPlace'+result.lawProject_id).html(result.lawProject_place);
                        $('#tdLawDate'+result.lawProject_id).html(result.lawProject_date_publish);
                        $('#tdLawApproved'+result.lawProject_id).html('<label class="label label-success">Sim</label>');
                        $('#modalApproved').modal('hide');
                    } else {
                        $('#labelmessage').html(result.message);
                        $('#law_number').val(result.next_number);
                    }
                });
            }
        });

        $('#save-reply').on('click', function(){
            id = this.value;
            url = '/lawsProjectsReply/' + this.value;
            data = {
                description: CKEDITOR.instances['comissionDescriprion'].getData(),
                file: "fileAjax"
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data
            }).success(function(response){
            }).error(function(e){
            });
        });
    });

    const changeRead = function(id){
        const url = '/lawsProjects-read/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result) {
        });
    };

    const deletaBash = function()
    {
        const ids = getCheckeds();
        const data_ = {
            ids: ids
        }

        $.ajax({
            url: "/lawProjects/deleteBash",
            _token: "{{ csrf_token() }}",
            data: data_,
            method: "POST"
        }).success(function(data){
            data = JSON.parse(data);

            $.each(data, function (index, value) {
                $('#row_'+ value).fadeOut(300);
            })

            window.location.reload()
        })
    };

    const activeDelete = function()
    {
        const btn = $('.deleteAll');
        checkSelected(btn);
    }

    const getCheckeds = function()
    {
        const searchIDs = [];

        $('.checkDelete:checked').map(function(){

            searchIDs.push($(this).val());

        });

        return searchIDs;
    }

    const checkSelected = function(btn)
    {
        const searchIDs = getCheckeds();

        if(searchIDs.length > 0)
        {
            btn.show();
        }else{
            btn.hide();
        }

    }

    $(document).ready(function () {

        $("#checkAll").click(function () {
            $('.checkDelete').prop('checked', $(this).prop('checked'));
            activeDelete();
        });

        $('.checkDelete').on('change', function () {
            activeDelete();
        })
    });

</script>
