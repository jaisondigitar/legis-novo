    @foreach($lawsProjects as $lawsProject)
<style>
    .acao{
        float: right;
    }
    .acao a {
        margin-right: 4px;
    }
</style>

<div class="col-lg-12 col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="panel-title text-uppercase" style="font-size: 15px;">
                <label>
                    <input type="checkbox" name="toDelete" value="{{$lawsProject->id}}" class="checkDelete " />
                </label>
                @if(!$lawsProject->law_type)
                    {{ $lawsProject->law_type_id }}
                @else
                    {!! mb_strtoupper($lawsProject->law_type->name, 'UTF-8') !!}
                @endif

                <span id="tdLawProjectNumber{{$lawsProject->id}}">
                    {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!}
                </span>
            </span>
        </div>
        <div class="panel-body">
            <div class="col-md-12" style="font-size: 12px;">
                <div class="form-group col-sm-2 pull-right">
                    {!! Form::label('town_hall', 'Aprovado pela câmara:') !!}
                    <div class="clearfix"></div>
                    <label>
                        <input
                            type="checkbox"
                            id ='town_hall{{$lawsProject->id}}'
                            onchange='toogleApproved({{$lawsProject->id }})'
                            class='form-control switch'
                            data-on-text='Sim'
                            data-off-text='Não'
                            data-off-color='danger'
                            data-on-color='success'
                            data-size='normal'
                            @if($lawsProject->town_hall == 1)
                            checked
                            @endif
                        >
                    </label>
                </div>
                <table>
                    <tr>
                        <td>
                            <strong>COD:</strong>
                            {!! $lawsProject->getNumberLaw() == 'false'  ? '-'  : $lawsProject->getNumberLaw() !!}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Data: </strong> {{$lawsProject->law_date}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Responsável: </strong>

                            @if($lawsProject->owner)
                                {{ $lawsProject->owner->short_name }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Comissão: </strong>

                            @if($lawsProject->comission)
                                {{ $lawsProject->comission->name }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Protocolo: </strong>
                            <span id="tdLawProtocol{{$lawsProject->id}}" align="center">
                                @if($lawsProject->project_number > 0)
                                    {{ $lawsProject->protocol }} - {{$lawsProject->protocoldate}}
                                @else
                                    @shield('lawsProject.approved')
                                        <button type="button" class="btn btn-default btn-xs btn-protocol" value="{!! $lawsProject->id !!}">
                                            <i class="glyphicon glyphicon-folder-open"></i>
                                        </button>
                                    @endshield
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong> Aprovado: </strong>

                            @if($lawsProject->is_ready === 1)
                                <span id="tdLawApproved_{{$lawsProject->id}}">
                                    {{$lawsProject->law_number}} - {{$lawsProject->law_date_publish}}
                                </span>

                                @shield('lawProject.approvedEdit')
                                    <button type="button" class="btn btn-warning btn-xs" onclick="approvedEdit('{{ $lawsProject->id }}')">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                @endshield
                            @else
                                @shield('lawsProject.approved')
                                    <span id="tdLawApproved{{$lawsProject->id}}" align="center">
                                        <button type="button" class="btn btn-default btn-xs btn-approved" value="{!! $lawsProject->id !!}">
                                            <i class="glyphicon glyphicon-folder-open"></i>
                                        </button>
                                    </span>
                                @endshield
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Aprovado pela câmara: </strong>

                            {{ $lawsProject->town_hall ? 'Sim' : 'Não' }}

                            @if($lawsProject->reference_id > 0)
                                <br>
                                <strong>Referente à: </strong>
                                <a href="/lawsProjects/{{$lawsProject->reference_id}}" target="_blank">
                                    {{--{{ \App\Models\LawsProject::find($lawsProject->reference_id)->project_number}}/--}}
                                    {{--{{\App\Models\LawsProject::find($lawsProject->reference_id)->getYearLaw($lawsProject->law_date)}} ---}}
                                    {{--{{ \App\Models\LawsProject::find($lawsProject->reference_id)->law_type->name}}--}}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Lida:</strong>

                            @shield('lawsProject.read')
                                <label>
                                    <input
                                        onchange="changeRead('{!! $lawsProject->id !!}')"
                                        type="checkbox" {!! $lawsProject->is_read > 0 ? 'checked' : '' !!}
                                    >
                                </label>
                            @endshield
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span style="text-align: justify !important;" class="text-uppercase">
                                {!! $lawsProject->title !!}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel-footer">
            {!! Form::open(['route' => ['lawsProjects.destroy', $lawsProject->id], 'method' => 'delete']) !!}
            <div class='btn-group col-md-12'>
                @shield('lawsProject.advices')
                    <a href="{!! route('lawsProjects.advices', [$lawsProject->id]) !!}" class='btn btn-default btn-sm'>
                        HISTÓRICO
                    </a>
                @endshield

                @shield('lawsProjects.edit')
                    <a href="{!! route('lawsProjects.structure', [$lawsProject->id]) !!}" class='btn btn-default btn-sm'>
                        ESTRUTURA DA LEI
                    </a>
                @endshield

                @shield('lawsProject.editprotocollei','lawsProject.editnumerolei')
                    <a href="javascript:void(0)" class='btn btn-default btn-sm' onclick="editNumero({{$lawsProject->id}})">
                        ALTERAR NÚMERO/PROTOCOLO
                    </a>
                @endshield

                @if($lawsProject->law_file)
                    <a href="/laws/{{ $lawsProject->law_file }}" target="_blank" class='btn btn-default btn-sm'>
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </a>
                @endif

                @shield('lawsProjects.show')
                    <a
                        href="{!! route('lawsProjects.show', [$lawsProject->id]) !!}"
                        target="_blank"
                        class='btn btn-default btn-sm'
                    >
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                @endshield

                @if($lawsProject->file)
                    <a href="/laws/{{ $lawsProject->file }}" target="_blank" class='btn btn-default btn-sm'>
                        <i class="fa fa-paperclip"></i>
                    </a>
                @endif

                @if($lawsProject->voting)
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#votes_{{ $lawsProject->id }}">
                        VOTAÇÃO
                    </button>
                @endif

                @shield('lawsProjects.edit')
                    <a href="{!! route('lawsProjects.edit', [$lawsProject->id]) !!}" class='btn btn-warning btn-sm'>
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                @endshield

                @shield('lawsProjects.delete')
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                @endshield

                <a href="/lawproject/{{$lawsProject->id}}/addFiles" class="pull-right btn btn-info btn-sm">
                    <i class="fa fa-plus"></i> Anexos
                </a>
            </div>
            <div class="clearfix"></div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@if($lawsProject->voting)
<div class="modal fade" id="votes_{{ $lawsProject->id }}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content modal-no-shadow">
            <div class="modal-header bg-dark no-border">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
                    VOTACÃO :
                    @if(!$lawsProject->law_type) {{ $lawsProject->law_type_id }} @else {!! mb_strtoupper($lawsProject->law_type->name, 'UTF-8') !!} @endif

                    <span id="tdLawProjectNumber{{$lawsProject->id}}">
                    {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!}
                </span>
                </h4>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="list_votacao">
                    @foreach($lawsProject->voting()->get() as $item)
                    <li class="list-group-item">
                        Data da votação : {{ date("d/m/Y", strtotime($item->open_at))}}
                        <span class="pull-right @if($item->situation($item)) text-primary @else text-danger @endif" >
                            @if($item->situation($item))
                                Votação Aprovada
                            @else
                                Votação Reprovada
                            @endif
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content .modal-no-shadow -->
    </div><!-- /.modal-dialog -->
</div>
@endif
@endforeach
{{--MODAL VOTAÇÃO--}}


{!! $lawsProjects->appends(request()->input())->render() !!}

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
                <h4 class="modal-title">Aprovar lei</h4>
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
                    {!! Form::text('project_number', null, ['class' => 'form-control', 'id' => 'project_number']) !!}
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
                    {!! Form::text('project_number_edit', null, ['class' => 'form-control', 'id' => 'project_number_edit']) !!}
                </div>
                @else
                    <div class="form-group col-sm-12">
                        {!! Form::label('project_number_edit', 'Número projeto de lei:') !!}
                        {!! Form::text('project_number_edit', null, ['class' => 'form-control', 'id' => 'project_number_edit', 'readonly']) !!}
                        <label class="label label-info">*Sem permissão para alterar.</label>
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

            data = getData();

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
                $('#modalProtocol').modal('show');
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
