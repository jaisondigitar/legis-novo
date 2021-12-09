<style>
    .action{
        float: right;
    }
    .action a {
        margin-right: 4px;
    }
    .resume {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        margin: 0;
    }
</style>

@foreach($documents as $document)
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center;">
            <span class="panel-title text-uppercase" style="font-size: 15px; margin-bottom: 0;">
                <span class="panel-title text-uppercase" style="font-size: 15px; margin-bottom: 0;">
                    <label class="pull-right">
                        <input type="checkbox" name="toDelete" value="{{$document->id}}" class="checkDelete"/>
                    </label>

                    <label class="pull-left">
                        <i class="fa fa-file" style="margin-right: 5px;"></i>

                        @if($document->document_type->parent_id)
                                {{ $document->document_type->parent->name }} ::
                            @endif
                            {!! $document->document_type->name !!} -
                        @if($document->number==0)
                            -
                        @elseif($document->number!=0)
                            @shield('document.editnumero')
                            <a href="javascript:void(0)" id="numberEdit{{$document->id}}" onclick="alteraNumero('{{$document->id}}');">
                                {!! $document->number !!}{!!'/' . $document->getYear($document->date) !!}
                            </a>
                            @endshield
                        @else
                            @shield('document.editnumero')
                            {!! $document->number . '/' . $document->getYear($document->date) !!}
                            @endshield
                        @endif
                    </label>

                    <label>
                        <span>
                            {!! $document->date !!}
                        </span>
                    </label>
                </span>
            </span>
        </div>
        <div class="panel-body">
            <span class="col-md-12" style="padding: 0; font-size: 13px;">
                <div class="col-md-6">
                    <span class="text-uppercase">
                        <label>
                            <i class="fa fa-user"></i> @if($document->owner) {!! $document->owner->short_name !!} @else - @endif <br>
                        </label>
                    </span>
                    <br>
                    <span>
                        <label>
                            <strong>Número:</strong>
                            <span id="tdnumber{{$document->id}}">
                                @if($document->number==0)
                                    -
                                @elseif($document->number != 0)
                                    @shield('document.editnumero')
                                        <a href="javascript:void(0)" id="numberEdit{{$document->id}}" onclick="alteraNumero('{{$document->id}}');">
                                            {!! $document->number !!}{!!'/' . $document->getYear($document->date) !!}
                                        </a>
                                    @endshield
                                @else
                                    @shield('document.editnumero')
                                        {!! $document->number . '/' . $document->getYear($document->date) !!}
                                    @endshield
                                @endif
                            </span>
                        </label>
                    </span>
                    <br>
                    <span>
                        <label>
                            <strong>Protocolo: </strong>
                            <span id="tdprotocol{{$document->id}}">

                                @if(!$document->document_protocol && Auth::user()->sector->slug!="secretaria")
                                    -
                                @elseif(!$document->document_protocol && Auth::user()->sector->slug=="secretaria")
                                    <button type="button" class='btn btn-default btn-xs btn-protocol' value="{!! $document->id !!}">
                                        <i class="glyphicon glyphicon-folder-open"></i>
                                    </button>
                                @else
                                    @shield('document.editprotocol')
                                        <a href="javascript:void(0)" id='linkProtocolo{{$document->id}}' onclick="alteraProtocolo('{!!$document->id!!}', '{{date('d/m/Y H:i:s', strtotime($document->document_protocol->created_at))}}');">
                                            @if($document->document_protocol)
                                                {{$document->document_protocol->number}}
                                            @endif
                                        </a>
                                    @endshield
                                @endif
                            </span>
                        </label>
                    </span>
                    <br>
                    <label>
                        <strong class="">Data Prot.:</strong>
                        <span id="tddate{{$document->id}}">
                            @if($document->document_protocol)
                                {{date('d/m/Y', strtotime($document->document_protocol->created_at))}}
                            @else
                                -
                            @endif
                        </span>
                    </label>
                </div>

                <div class="col-md-6">
                    @shield('document.read')
                        <label for="lido_{{$document->id}}">
                            <strong>Lido:</strong>
                            <input id="lido_{{$document->id}}" type="checkbox" onclick="changeRead('{!! $document->id !!}')" {!! $document->read > 0 ? 'checked' : '' !!}>
                        </label>
                    @endshield
                    @shield('document.approved')
                        <span>
                            <label>
                            <strong>Aprovado:</strong>
                                <input onchange="changeApproved('{!! $document->id !!}')" type="checkbox" {!! $document->approved > 0 ? 'checked' : '' !!} >
                            </label>
                        </span>
                    @endshield
                    <br>
                    <span>
                        <label>
                            <strong>Data Tram.:</strong>
                            <span>
                                @if(count($document->processingDocument)===0)
                                    -
                                @else
                                    {!! $document->processingDocument->first()->processing_document_date !!}
                                @endif
                            </span>
                        </label>
                    </span>
                    <br>
                    <span>
                        <label>
                            <strong>Status:</strong>
                            <span>
                                @if(count($document->processingDocument)===0)
                                    -
                                @else
                                    {!! $document->processingDocument->first()->statusProcessingDocument->name !!}
                                @endif
                            </span>
                        </label>
                    </span>
                    <br>
                    <label for="lido_{{$document->id}}">
                        <strong>Destinatário:</strong>
                        <span>
                            @if(count($document->processingDocument)===0)
                                -
                            @else
                                {!! $document->processingDocument->first()->destination->name !!}
                            @endif
                        </span>
                    </label>
                </div>
                <div class="col-md-12", style="padding-bottom: 0">
                    <label style="margin-top: 10px; min-height: 8rem">
                        <strong>Ementa:</strong>
                        <span>
                            @if($document->resume==='')
                                -
                            @else
                                <p class="resume">
                                    {!! $document->resume !!}
                                </p>
                            @endif
                        </span>
                    </label>
                </div>
            </span>
        </div>
        <div class="panel-footer">
            @if(!$document->document_protocol)
                <span class="badge badge-warning pull-left">Aberto</span>
            @else
                <span class="badge badge-info pull-left">Protocolado</span>
            @endif
            {!! Form::open(['route' => ['documents.destroy', $document->id], 'method' => 'delete']) !!}

            <div class='btn-group action' id="tdoptions{{$document->id}}">
                @shield('documents.show')
                    <a href="{!! route('documents.show', [$document->id]) !!}" target="_blank" class='btn btn-default btn-xs'>
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>
                @endshield
                @if(!$document->document_protocol || Auth::user()->sector_id == 1)
                    @shield('documents.edit')
                        <a href="{!! route('documents.attachament', [$document->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="glyphicon glyphicon-paperclip"></i>
                        </a>
                    @endshield
                @endif
                @if(!$document->document_protocol || Auth::user()->sector_id == 1)
                    @shield('documents.edit')
                        <a href="{!! route('documents.edit', [$document->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                    @endshield
                    @shield('documents.advices')
                        <a href="{!! route('documents.advices', [$document->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="glyphicon glyphicon-list-alt"></i>
                        </a>
                    @endshield
                    @shield('documents.delete')
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @endshield
                @endif
            </div>
            <div class="clearfix"></div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endforeach

<div class="clearfix"></div>

{!! $documents->appends(request()->input())->render() !!}

<div id="modalProtocol" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Protocolo de documento</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="document_id" id="document_id">
                <input type="hidden" name="next_number_origin" id="next_number_origin">
                <div class="form-group col-sm-4">
                    {!! Form::label('protocol_date', 'Data:') !!}
                    {!! Form::text('protocol_date', null, ['class' => 'form-control ', 'id' => 'protocol_date', 'required']) !!}
                </div>

                <div class="form-group col-sm-4">
                    <?php
                    $externo = \App\Models\Parameters::where('slug', 'sempre-usa-protocolo-externo')->first()->value;

                    $prot = $externo ? 2 : 1;
                    ?>
                    {!! Form::label('protocol_type_id', 'Tipo de protocolo') !!}
                    {!! Form::select('protocol_type_id', $protocol_types, $prot, ['class' => 'form-control', 'id' => 'protocol_type_id']) !!}
                </div>

                <div class="form-group col-sm-4">
                    {!! Form::label('protocol_number', 'Número protocolo:') !!}
                    {!! Form::text('protocol_number', null, ['class' => 'form-control', 'id' => 'protocol_number']) !!}
                </div>
                <div class="form-group col-sm-4">
                    {!! Form::label('next_number', 'Nº documento oficial:') !!}
                    {!! Form::number('next_number', null, ['class' => 'form-control', 'id' => 'next_number']) !!}
                    <label class="label label-danger" id="labelmessage"></label>
                </div>
                {{--<div class="form-group col-sm-4">--}}
                    {{--{!! Form::label('version', 'Versão:') !!}--}}
                    {{--{!! Form::text('version', null, ['class' => 'form-control', 'id' => 'version']) !!}--}}
                    {{--<label class="label label-danger" id="labelmessage"></label>--}}
                {{--</div>--}}
                <div class="form-group col-sm-4">
                    {!! Form::label('year_document', 'Ano documento oficial:') !!}
                    {!! Form::text('year_document', null, ['class' => 'form-control', 'id' => 'year_document', 'readonly']) !!}
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
                <h4 class="modal-title">Protocolo de documento</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="document_id" id="document_id_edit">
                <input type="hidden" name="next_number_origin" id="next_number_origin">

                <div class="form-group col-sm-4">
                    {!! Form::label('date_protocolo_edit', 'Data do protocolo:') !!}
                    {!! Form::text('date_protocolo_edit', null, ['class' => 'form-control', 'id' => 'protocol_date_edit']) !!}
                    <label class="label label-danger" id="labelmessageedit"></label>
                </div>

                <div class="form-group col-sm-4">
                    {!! Form::label('protocol_number', 'Número protocolo:') !!}
                    {!! Form::text('protocol_number', null, ['class' => 'form-control', 'id' => 'protocol_number_edit']) !!}
                    <label class="label label-danger" id="labelmessageedit"></label>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="limpaedit()">Close</button>
                <button type="button" class="btn btn-success pull-right" id="btn-edit-protocol" onclick="editProtocolo()" >Alterar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalNumerolEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Protocolo de documento</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="document_id" id="document_id_edit_number">
                <input type="hidden" name="date_protocol_edit" id="date_protocol_edit">
                <input type="hidden" name="next_number_origin" id="next_number_origin">

                <div class="form-group col-sm-4">
                    {!! Form::label('document_number_edit', 'Número Documento:') !!}
                    {!! Form::text('document_number_edit', null, ['class' => 'form-control', 'id' => 'document_number_edit']) !!}
                    <label class="label label-danger" id="labelmessageeditnum"></label>
                </div>

                {{--<div class="form-group col-sm-4">--}}
                    {{--{!! Form::label('document_version_edit', 'Versão Documento:') !!}--}}
                    {{--{!! Form::text('document_version_edit', null, ['class' => 'form-control', 'id' => 'document_version_edit']) !!}--}}
                    {{--<label class="label label-danger" id="labelmessageeditnum"></label>--}}
                {{--</div>--}}

            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="limpaedit()">Close</button>
                <button type="button" class="btn btn-success pull-right" id="btn-edit-protocol" onclick="editNumber()" >Alterar</button>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function(){
        $('#protocol_date').datetimepicker({format: 'DD/MM/YYYY HH:mm:ss'});
        $('#protocol_date_edit').datetimepicker({format: 'DD/MM/YYYY HH:mm:ss'});



        var data = new Date();
        var dia     = data.getDate();           // 1-31
        var dia_sem = data.getDay();            // 0-6 (zero=domingo)
        var mes     = data.getMonth();          // 0-11 (zero=janeiro)
        var ano2    = data.getYear();           // 2 dígitos
        var ano4    = data.getFullYear();       // 4 dígitos
        var hora    = data.getHours();          // 0-23
        var min     = data.getMinutes();        // 0-59
        var seg     = data.getSeconds();        // 0-59
        var mseg    = data.getMilliseconds();   // 0-999
        var tz      = data.getTimezoneOffset(); // em minutos

        if(dia<=9){
            dia = '0' + dia;
        }

        mes = mes + 1;
        if(mes <= 9){
            mes = '0' + mes;
        }


        if(hora<=9){
            hora = '0' + hora;
        }

        if(min<=9){
            min = '0' + min;
        }

        if(seg<=9){
            seg = '0' + seg;
        }

        date = dia + '/' + mes + '/' + ano4+ ' '+ hora + ':' + min + ':' + seg ;


        $('#protocol_date').val(date);

    });

    var converteDate = function(date1){

        var data = new Date(date1);
        var dia     = data.getDate();           // 1-31
        var dia_sem = data.getDay();            // 0-6 (zero=domingo)
        var mes     = data.getMonth();          // 0-11 (zero=janeiro)
        var ano2    = data.getYear();           // 2 dígitos
        var ano4    = data.getFullYear();       // 4 dígitos
        var hora    = data.getHours();          // 0-23
        var min     = data.getMinutes();        // 0-59
        var seg     = data.getSeconds();        // 0-59
        var mseg    = data.getMilliseconds();   // 0-999
        var tz      = data.getTimezoneOffset(); // em minutos

        if(dia<=9){
            dia = '0' + dia;
        }

        mes = mes + 1;
        if(mes <= 9){
            mes = '0' + mes;
        }


        if(hora<=9){
            hora = '0' + hora;
        }

        if(min<=9){
            min = '0' + min;
        }

        if(seg<=9){
            seg = '0' + seg;
        }

        date = dia + '/' + mes + '/' + ano4+ ' '+ hora + ':' + min + ':' + seg ;


        return date;

    };

    var alteraProtocolo = function(id, date){

        $('#document_id_edit').val(id);
        $('#date_protocol_edit').val(date);
        $('#protocol_date_edit').val(date);


        $('#modalProtocolEdit').modal();
    };

    var alteraNumero = function (id){

        limpaedit();
        $('#document_id_edit_number').val(id);
        $('#modalNumerolEdit').modal();

    };

    var limpaedit = function(){

        $('#document_id_edit').val('');
        $('#date_protocol_edit').val('');
        $('#labelmessageedit').html('');
        $('#labelmessageeditnum').html('');
        $('#protocol_number_edit').val('');
        $('#document_number_edit').val('');


    };

    var editProtocolo = function(){

        url = '/protocolo/altera-protocolo';

        data = {
            id : $('#document_id_edit').val(),
            protocolo : $('#protocol_number_edit').val(),
            date_protocolo : $('#protocol_date_edit').val(),
            '_token' : '{{ csrf_token() }}'
        };

        $.ajax({
            url : url,
            data : data,
            method : 'POST'
        }).success(function(data){

            data = JSON.parse(data);

            if (data){
                $('#linkProtocolo' + data.document_id).html(data.number);
                dataCon = converteDate(data.created_at);
                $('#tddate'+data.document_id).html(dataCon);

                $('#protocol_number_edit').val('');
                $('#modalProtocolEdit').modal('hide');
                $('#labelmessageedit').html('');
            }
            else{
                $('#labelmessageedit').html('Protocolo em uso.');
            }
        });
    };

    var editNumber = function(){

        if($('#document_number_edit').val() == '') {
            $('#labelmessageeditnum').html('Digite o número do documento');
        }else {

            url = '/protocolo/altera-numero';

            data = {
                document_id: $('#document_id_edit_number').val(),
                doc_number: $('#document_number_edit').val(),
                doc_version: $('#document_version_edit').val(),
                '_token': '{{csrf_token()}}'
            };

            $.ajax({
                url: url,
                data: data,
                method: 'POST'
            }).success(function (result) {

                if (result.success) {
                    $('#modalNumerolEdit').modal('hide');
                    $('#numberEdit' + result.id).html(result.next_number);

                } else {
                    $('#document_number_edit').val(result.next_number);
                    $('#labelmessageeditnum').html(result.message);
                }

            });
        }
    };


    var deletaBash = function()
    {
        var ids = getCheckeds();
        var data_ = {
          ids: ids
        }

        $.ajax({
          url: "/documents/deleteBash",
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

    var activeDelete = function()
    {
      var btn = $('.deleteAll');
      checkSelected(btn);
    }

    var getCheckeds = function()
    {
      var searchIDs = [];

        $('.checkDelete:checked').map(function(){

           searchIDs.push($(this).val());

         });

         return searchIDs;
    }

    var checkSelected = function(btn)
    {
      var searchIDs = getCheckeds();

         if(searchIDs.length > 0)
         {
           btn.show();
         }else{
           btn.hide();
         }

    }

    $(document).ready(function () {

      $("#checkAll").click(function(){
         $('.checkDelete').prop('checked', $(this).prop('checked'));
         activeDelete();
      });

      $('.checkDelete').on('change',function(){
         activeDelete();
      })

        $('.btn-protocol').click( function () {
            var id = this.value;
            $.ajax({
                method: "GET",
                url: "{{ url('document-protocol') }}/"+ id,
                dataType: "json"
            }).success(function (result) {
                $('#document_id').val(result.data.document_id);
                $('#protocol_number').val(result.data.protocol_number);
                $('#next_number').val(result.data.next_number);
                $('#next_number_origin').val(result.data.next_number);
                $('#year_document').val(result.data.year);
                $('#labelmessage').html('');
                $('#protocol_date').val(date);
                $('#modalProtocol').modal('show');
            });
        });

        $('#btn-save-protocol').click( function () {
            if($('#protocol_type_id').val() == '') {
                $('#labelmessage').html('Selecione um tipo de protocolo');
            }else {
                var data = {
                    document_id: $('#document_id').val(),
                    protocol_number: $('#protocol_number').val(),
                    next_number: $('#next_number').val(),
                    version: $('#version').val(),
                    protocol_type_id: $('#protocol_type_id').val(),
                    next_number_origin: $('#next_number_origin').val(),
                    protocol_date: $('#protocol_date').val(),
                };
                $.ajax({
                    method: "POST",
                    url: "{{ url('document-protocol-save') }}",
                    data: data,
                    dataType: "json"
                }).success(function (result) {
                    if(result.success){
                        $('#modalProtocol').modal('hide');
                        @if(Auth::user()->sector_id != 1)
                            $('#tdoptions'+result.document_id).hide();
                        @endif
                        $('#tdnumber'+result.document_id).html(result.protocol_number);
                        $('#tddate'+result.document_id).html(result.protocol_date);
                        $('#tdprotocol'+result.document_id).html(result.protocol_code);
                    } else {
                        $('#next_number').val(result.next_number);
                        $('#labelmessage').html(result.message);
                    }

                    $('#protocol_date').val('');
                });
            }
        });
    });

    var changeRead = function(id){

        var url = '/documents-read/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
           // console.log(result);
        });
    }

    var changeApproved = function(id){
        var url = '/documents-approved/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
//            console.log(result);
        });
    }


</script>
