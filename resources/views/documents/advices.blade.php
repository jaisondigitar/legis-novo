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

                            @if(Auth::user()->roleHasPermission('dateAdvicesDocument.edit'))
                                <div class="form-group col-sm-3">
                                    {!! Form::label('new_processing_document_date', 'Data:') !!}
                                    {!! Form::text('new_processing_document_date', null, ['class' => 'form-control datetimepicker1']) !!}
                                </div>
                            @else
                                <div class="form-group col-sm-3">
                                    {!! Form::label('new_processing_document_date', 'Data:') !!}
                                    {!! Form::text('new_processing_document_date', null, ['class' => 'form-control datetimepicker1', 'disabled']) !!}
                                </div>
                            @endif

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
                                    @forelse($documents as $key => $processing)
                                        <tr id="line_{{ $processing->id }}">
                                            <td > {{ $processing->processing_document_date }}</td>
                                            <td > {{ $processing->documentSituation->name }}</td>
                                            <td > {{ $processing->statusProcessingDocument->name ?? '' }}</td>
                                            <td > {{ $processing->destination->name ?? '' }}</td>
                                            <td style="text-align: justify;"> {!! $processing->observation !!}</td>
                                            @if(Auth::user()->id == $processing->owner_id || $first_documents->id === $processing->id || Auth::user()->hasRole('root'))
                                                <td> <button type="button" class="btn btn-danger btn-xs" onclick="delete_processing('{{$processing->id}}')"> <i class="fa fa-trash"></i> </button> </td>
                                            @endif
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
  @endif
  <div class="clearfix">

  </div>
</div>


<script>
    document.querySelector('#new_processing_document_date').value = dateForm + '' + timeForm

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
                        processing_document_date_first: '{{ $first_documents->processing_document_date ?? '' }}',
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

                        if (data) {
                            @if(isset($processing))
                                table = $('#table_processing').empty();

                                data.forEach(function (valor) {
                                    str = '<tr id="line_' + valor.id + '"> ';
                                    str += "<td>";
                                    str += valor.processing_document_date ?? '';
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
                                    @if(Auth::user()->id == $processing->user_id || Auth::user()->hasRole('root'))
                                    str += "<td>";
                                    str += '<button type="button" class="btn btn-danger btn-xs" onclick="delete_processing(' + valor.id + ')"> <i class="fa fa-trash"></i> </button>';
                                    str += "</td>";
                                    @endif

                                    str += "</tr>";
                                    table.append(str);
                                });
                            @endif

                            toastr.success('Tramitação salva com sucesso!');

                            $('#new_document_situation_id').val(0);
                            $('#new_status_processing_document_id').val(0);
                            $('#new_processing_document_date').val('');
                            CKEDITOR.instances.new_document_observation.setData('');

                            window.location.href = '{{route('documents.index')}}';
                        } else {
                            toastr.error("Data menor que a do ultimo tramite");
                        }
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
