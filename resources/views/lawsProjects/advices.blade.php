@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.show') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="form-group">
        <a href="{!! route('lawsProjects.index') !!}" class="btn btn-default">Voltar</a>
    </div>

    @if(isset($lawsProject))
        @if(isset($lawsProject->id) && $tramitacao)
            <div class="form-group col-sm-12">
                <div class="panel panel-square panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-angle-double-right"></i> TRAMITAÇÃO</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group col-sm-3">
                            {!! Form::label('new_advice_situation_id', 'Situação do projeto:') !!}
                            {!! Form::select('new_advice_situation_id', $advice_situation_law ,null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-3">
                            {!! Form::label('new_status_processing_law_id', 'Status do trâmite:') !!}
                            {!! Form::select('new_status_processing_law_id', $status_processing_law ,null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-2">
                            {!! Form::label('new_date_processing', 'Data:') !!}
                            {!! Form::text('new_date_processing', null, ['class' => 'form-control datepicker']) !!}
                        </div>

                        <div class="form-group col-sm-2">
                            {!! Form::label('destination_id', 'Destinatários:') !!}
                            {!! Form::select('destination_id', $destinations, null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-2">
                            {!! Form::label('date_end', 'Prazo:') !!}
                            {!! Form::text('date_end', null, ['class' => 'form-control datepicker']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('new_observation', ' Observações:') !!}
                            {!! Form::textarea('new_observation', null, ['class' => 'form-control ckeditor']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            <button class="btn btn-info pull-right" type="button" onclick="save_processing()">
                                Salvar
                            </button>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-th-block table-dark">
                                <thead>
                                    <tr>
                                        <th width="100">
                                            Data
                                        </th>
                                        <th width="150">
                                            Situação do projeto
                                        </th>
                                        <th width="150">
                                            Destinatário
                                        </th>
                                        <th width="150">
                                            Status do trâmite
                                        </th>
                                        <th width="500">
                                            Observação
                                        </th>
                                        <th width="50">
                                            Prazo
                                        </th>
                                        <th width="20">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table_processing">
                                    @forelse($lawsProject->processing()->orderBy('processing_date', 'desc')->get() as $processing)
                                        <tr id="line_{{$processing->id}}">
                                            <td> {{$processing->processing_date}}</td>
                                            <td> {{$processing->adviceSituationLaw->name}}</td>
                                            <td> {{ $processing->destination->name ?? '' }}</td>
                                            <td> @if($processing->statusProcessingLaw) {{$processing->statusProcessingLaw->name}} @endif</td>
                                            <td style="text-align: justify;"> {!! $processing->obsevation !!}</td>
                                            <td style="text-align: justify;"> {!! $processing->date_end !!}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        onclick="delete_processing('{{$processing->id}}')"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
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
        @endif

        <script>
            document.querySelector('#new_date_processing').value = dateForm

            $(document).ready(function () {
                setTimeout(function () {
                    $('#comissao').addClass('chosen-select')
                }, 500);
            });

            var addChosen = function () {

                $('#comissao').addClass('chosen-select')

            };

            var newAdvice = function (project_id) {
                var url = "/advice/create";
                var laws_projects_id = project_id;
                var to_id = [];
                var type = [];
                var label = [];

                $('#comissao :selected').each(function (i, sel) {
                    to_id[i] = $(sel).val().substr(1);
                    type[i] = $(sel).val().substr(0, 1);
                    label[i] = $(sel).text();
                });

                const data = {
                    laws_projects_id: laws_projects_id,
                    document_id: 0,
                    to_id: to_id,
                    type: type,
                    description: CKEDITOR.instances['comissionDescriprion'].getData(),
                    legal_opinion: CKEDITOR.instances['legalOpinion'].getData(),
                    date_end: $('#date_end').val(),
                }

                if (to_id.length > 0) {

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: data
                    }).success(function (data) {
                        data = JSON.parse(data);

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
    if ({{Auth::user()->can_request_secretary}}) {
        $('body').on('change', '#destination_id', () => {
            if ($('#destination_id').val() == 4) {
                document.querySelector('#date_end').value = someDateForm
            } else {
                document.querySelector('#date_end').value = ''
            }
        });
    }


    var save_processing = function(){

        url = '{{route('processings.store')}}';

        if($('#new_advice_situation_id').val() == ''){
            toastr.error('Selecione a situação da tramitação!')
        }else {
            if($('#new_status_processing_law_id').val() == ''){
                toastr.error('Selecione um status para tramitação!');
            }else {
                if($('#new_date_processing').val() == ''){
                    toastr.error('Selecione uma data para tramitação!');
                }else {
                    const data = {
                        law_projects_id: '{{ $lawsProject->id }}',
                        advice_publication_id: $('#new_advice_publication_id').val(),
                        advice_situation_id: $('#new_advice_situation_id').val(),
                        status_processing_law_id: $('#new_status_processing_law_id').val(),
                        processing_date: $('#new_date_processing').val(),
                        destination_id: $('#destination_id').val(),
                        processing_file: $('#processing_file').val(),
                        date_end: $('#date_end').val(),
                        obsevation: CKEDITOR.instances.new_observation.getData()
                    };

                    $.ajax({
                        url: url,
                        data: data,
                        method: 'post'
                    }).success(function (data) {
                        data = JSON.parse(data);

                        table = $('#table_processing').empty();

                        data.forEach(function (valor, chave) {

                            str = '<tr id="line_' + valor.id + '"> ';
                            str += "<td>";
                            str += valor.processing_date;
                            str += "</td>";
                            str += "<td>";
                            str += valor.advice_situation_law.name;
                            str += "</td>";
                            str += "<td>";
                            if (valor.destination) {
                                str += valor.destination.name;
                            }
                            str += "</td>";
                            str += "<td>";
                            if (valor.status_processing_law_id > 0) {
                                str += valor.status_processing_law.name;
                            }
                            str += "</td>";
                            str += "<td>";
                            str += valor.obsevation;
                            str += "</td>";
                            str += "<td>";
                            str += valor.date_end;
                            str += "</td>";
                            str += "<td>";
                            str += '<button type="button" class="btn btn-danger btn-xs" onclick="delete_processing(' + valor.id + ')"> <i class="fa fa-trash"></i> </button>';
                            str += "</td>";
                            str += "</tr>";
                            table.append(str);
                        });

                        toastr.success('Tramitação salva com sucesso!');

                        $('#new_advice_publication_id').val('');
                        $('#new_advice_situation_id').val('');
                        $('#new_status_processing_law_id').val('');
                        $('#new_date_processing').val('');
                        CKEDITOR.instances.new_observation.setData('');

                        window.location.href = '{{route('lawsProjects.index')}}';
                    });
                }
            }
        }

    }

    var delete_processing = function(id){

        if(confirm('Deseja excluir?')) {

            url = '/processings/' + id;

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
