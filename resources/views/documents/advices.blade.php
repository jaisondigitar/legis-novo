@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.show') !!}
@endsection
@section('content')
<div class="the-box rounded">
  <div class="form-group">
         <a href="{!! route('documents.index') !!}" class="btn btn-default">Voltar</a>
  </div>

  @if(isset($document))
  <div class="form-group col-sm-12">
      <div class="panel panel-square panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-angle-double-right"></i> PEDIDO DE PARECERES</h3>
              <div class="right-content">
                  <div class="btn-group btn-group-xs">
                      <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#newParecer" onclick="addChosen()">
                          <i class="fa fa-plus"></i> SOLICITAR PARECER
                      </button>
                  </div>
              </div>
          </div>
          <div class="panel-body">
              @include('documents.tramites_table')
          </div><!-- /.panel-body -->
      </div>
  </div>

  <div class="modal fade" id="newParecer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">PEDIDO DE DESTINO</h4>
              </div>
              <div class="modal-body">
                  <label>Selecione a comissão:</label>
                  <select class="form-control destination" multiple name="comission" id="comissao">
                      <optgroup label="Comissões">
                          @foreach(\App\Models\Commission::active()->get() as $comission)
                              <option value="c{{ $comission->id }}">{{ $comission->name }}</option>
                          @endforeach
                      </optgroup>
                  </select>
                  <label>Descrição:</label>
                  <textarea name="comissionDescriprion" class="form-control descricao ckeditor"></textarea>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                  <button type="button" class="btn btn-primary" onclick="newAdvice({{ $document->id }})">SOLICITAR</button>
              </div>
          </div>
      </div>
  </div>

        @if(isset($document->id) && $tramitacao)
            <div class="form-group col-sm-12">
                <div class="panel panel-square panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-angle-double-right"></i> TRAMITAÇÃO</h3>
                    </div>
                    <div class="panel-body">
                        <div class=" col-md-12 col-sm-12">
                            <div class="form-group col-sm-3">
                                {!! Form::label('new_document_situation_id', 'Situação do documento:') !!}
                                {!! Form::select('new_document_situation_id', $document_situation ,null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-sm-3">
                                {!! Form::label('new_status_processing_document_id', 'Status do trâmite:') !!}
                                {!! Form::select('new_status_processing_document_id', $status_processing_document, null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-sm-3">
                                {!! Form::label('destination_id', 'Destinatário:') !!}
                                {!! Form::select('destination_id', $destinations, null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-sm-3">
                                {!! Form::label('new_processing_document_date', 'Data:') !!}
                                {!! Form::text('new_processing_document_date', null, ['class' => 'form-control datepicker']) !!}
                            </div>

                            <div class="form-group col-sm-12">
                                {!! Form::label('new_document_observation', ' Observações:') !!}
                                {!! Form::textarea('new_document_observation', null, ['class' => 'form-control ckeditor']) !!}
                            </div>

                            <div class="form-group col-sm-12">
                                <a href="{!! route('documents.index') !!}" class="btn btn-default pull-right">Voltar</a>
                                <button class="btn btn-info pull-right" type="button" onclick="save_processing()"> Salvar </button>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-th-block table-dark">
                                    <thead>
                                    <tr>
                                        <th width="100">
                                            Data
                                        </th>
                                        <th width="150">
                                            Situação do documento
                                        </th>
                                        <th width="150">
                                            Status do trâmite
                                        </th>
                                        <th width="150">
                                            Destinatário
                                        </th>
                                        <th width="500">
                                            Observação
                                        </th>
                                        <th width="20">
                                            Ações
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_processing">
                                    @forelse($document->processingDocument()->orderBy('processing_document_date', 'desc')->get() as $processing)
                                        <tr id="line_{{ $processing->id }}">
                                            <td > {{ $processing->processing_document_date }}</td>
                                            <td > {{ $processing->documentSituation->name }}</td>
                                            <td > {{ $processing->statusProcessingDocument->name ?? '' }}</td>
                                            <td > {{ $processing->destination->name ?? '' }}</td>
                                            <td style="text-align: justify;"> {!! $processing->observation !!}</td>
                                            <td> <button type="button" class="btn btn-danger btn-xs" onclick="delete_processing('{{$processing->id}}')"> <i class="fa fa-trash"></i> </button> </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>
                                                <strong> Não existe tramitação </strong>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <script>
            document.querySelector('#new_processing_document_date').value = dateForm

            $(document).ready(function () {
                setTimeout(function () {
                    $('#comissao').addClass('chosen-select')
                }, 500);
            });

            const addChosen = () => {
                $('#comissao').addClass('chosen-select')
            };

            const newAdvice = (document_id) => {
                var url = "/advice/create";
                var document_id = document_id;
                var to_id = [];
                var type = [];
                var label = [];

                $('#comissao :selected').each(function (i, sel) {
                    to_id[i] = $(sel).val().substr(1);
                    type[i] = $(sel).val().substr(0, 1);
                    label[i] = $(sel).text();
                });

                const data = {
                    document_id: document_id,
                    laws_projects_id: 0,
                    to_id: to_id,
                    type: type,
                    description: CKEDITOR.instances['comissionDescriprion'].getData(),
                    date_end: null,
                };

                if (to_id.length > 0) {
                    $.ajax({
                        url: url,
                        data: data,
                        method: 'POST'
                    }).success(function (data) {
                        if (data) {
                            toastr.success("Pedido salvo com sucesso!!");
                        } else {
                            toastr.error("Erro ao salvar pedido!!");
                        }
                    })
                } else {
                    toastr.error('Selecione um destino!');
                }
            }

            function dataAtualFormatada(data) {
                var dia = data.getDate();
                if (dia.toString().length == 1)
                    dia = "0" + dia;
                var mes = data.getMonth() + 1;
                if (mes.toString().length == 1)
                    mes = "0" + mes;
                var ano = data.getFullYear();
                return dia + "/" + mes + "/" + ano;
            }
        </script>
  @endif
  <div class="clearfix">

  </div>
</div>


<script>
    var save_processing = function() {

        url = '{{route('processingDocuments.store')}}';

        if ($('#new_document_situation_id').val() == 0) {
            toastr.error('Selecione uma situação para tramitação!')
        } else {
            if ($('#new_status_processing_document_id').val() == 0) {
                toastr.error('Selecione um status para tramitação!');
            }
            else {
                if ($('#new_processing_document_date').val() == '') {
                    toastr.error('Selecione uma data para tramitação!');
                }
                else {
                    data = {
                        document_id: '{{ $document->id }}',
                        document_situation_id: $('#new_document_situation_id').val(),
                        status_processing_document_id: $('#new_status_processing_document_id').val(),
                        processing_document_date: $('#new_processing_document_date').val(),
                        destination_id: $('#destination_id').val(),
                        observation: CKEDITOR.instances.new_document_observation.getData(),
                        date_end: null,
                    };

                    $.ajax({
                        url: url,
                        data: data,
                        method: 'post'
                    }).success(function (data) {
                        data = JSON.parse(data);

                        table = $('#table_processing').empty();

                        data.forEach(function (valor) {
                            str = '<tr id="line_' + valor.id + '"> ';
                            str += "<td>";
                            str += valor.processing_document_date;
                            str += "</td>";
                            str += "<td>";
                            str += valor.document_situation.name;
                            str += "</td>";
                            str += "<td>";
                            if (valor.status_processing_document_id > 0) {
                                str += valor.status_processing_document.name;
                            }
                            str += "</td>";
                            str += "<td>";
                            if (valor.destination) {
                                str += valor.destination.name;
                            }
                            str += "</td>";
                            str += "<td>";
                            str += valor.observation || '';
                            str += "</td>";
                            str += "<td>";
                            str += '<button type="button" class="btn btn-danger btn-xs" onclick="delete_processing(' + valor.id + ')"> <i class="fa fa-trash"></i> </button>';
                            str += "</td>";
                            str += "</tr>";
                            table.append(str);
                        });

                        toastr.success('Tramitação salva com sucesso!');

                        $('#new_document_situation_id').val(0);
                        $('#new_status_processing_document_id').val(0);
                        $('#new_processing_document_date').val('');
                        CKEDITOR.instances.new_document_observation.setData('');

                        window.location.href = '{{route('documents.index')}}';
                    });
                }
            }
        }
    }


    var delete_processing = function(id){

        if(confirm('Deseja excluir?')) {

            url = '/processingDocuments/' + id;

            $.ajax({
                url: url,
                method: 'DELETE'
            }).success(function (data) {

                data = JSON.parse(data);

                $('#line_' + id).fadeOut();
                toastr.success('Tramitação excluída com sucesso!');

            });
        }
    }

</script>

@endsection
