@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.attachment') !!}
@endsection
@section('content')
    <a href="{{ url('documents') }}" ><button type="button" class="btn btn-dark" style="margin-bottom: 10px; color: #0A0A0A"><i class="glyphicon glyphicon-chevron-left"></i>Voltar</button></a>
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-3">
                @include('flash::message')
                {!! Form::open(['route' => ['documents.attachament.upload', $document->id], 'method' => 'post', 'files' => 'true']) !!}
                    <label class="control-label">Selecione o arquivo:</label>
                        {!! Form::file('file[]', array('multiple'=>true, 'class' => 'file')) !!}
                    <button type="submit" class="btn btn-success pull-right">Incluir</button>
                {!! Form::close() !!}
                <br>
                <hr class="hr">
            </div>
            <div class="col-md-9">
                <h4 align="center">Anexos:</h4>
                <table class="table table-bordered table-striped">
                    @foreach($document_files as $file)
                        <tr id="tr{{$file->id}}">
                            <td width="80%">{{ $file->filename }}</td>
                            <td align="center">
                                <a
                                    target="_blank"
                                    href="{{ (new \App\Services\StorageService())
                                    ->inDocumentsFolder()->getPath($file->filename) }}">
                                    <span class="label label-info">Download</span>
                                </a>
                                <a style="text-decoration: none" id="delFile" onclick="deleteFile({{$file->id}})">
                                    <span class="label label-danger">Excluir</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    @is(['admin','root'])

    <div class="the-box rounded" style="font-size: 12px">
        @include('common.errors')
        <div class="row">
            <div class="col-md-12">
                <h1> Log de registro </h1>
                <hr>
            </div>
            <style>
                .log{
                    padding: 15px;
                }
            </style>

            @foreach($logs as $key => $log)
                <div class="col-md-12">
                    <div class="col-lg-12 log" @if($key%2==0) style="border: 1px solid #ddd; background-color: #ddd;" @else style="border: 1px solid #ddd; background-color: #fff;" @endif>
                        <?php

                        switch ($log->event) {
                            case 'created': echo "<label class='badge badge-success'>CRIOU</label>"; break;
                            case 'updated': echo "<label class='badge badge-warning'>EDITOU</label>"; break;
                            case 'deleted': echo "<label class='badge badge-danger'>DELETOU</label>"; break;
                        }

                        echo ' '.date('d/m/Y h:i:s', strtotime($log->created_at));

                        $model = explode('\\', $log->auditable_type);

                        echo '<br><br>';

                        echo ' <b>USUÁRIO:</b> '.strtoupper($log->user->name).' <br> <b>EMAIL:</b> '.$log->user->email.'<br>';
                        echo '<b>IP:</b> '.$log->ip_address.'<br><br>';
                        echo '<b>Rota:</b> '.$log->url.'<br>';

                        if ($log->event == 'updated') {
                            echo '<br><p><strong>VALOR ANTIGO</strong></p>'.filter_var($log->old_values, FILTER_SANITIZE_STRING);
                        }

                        if ($log->event == 'updated' || $log->event == 'created') {
                            echo '<br><br><p><strong>NOVO VALOR</strong></p>'.filter_var($log->new_values, FILTER_SANITIZE_STRING);
                        }


                        ?>

                    </div>
                </div>
            @endforeach
            <div class="clearfix"></div>
            <br>
            <div class="col-md-12">
            <span class="pull-right">
                <a href="{{route('documents.index')}}" class="btn btn-default"> Voltar </a>
            </span>
            </div>
        </div>
    </div>


    @endis

    <script>
        function deleteFile(id) {
            var r = confirm('Deseja realmente apagar?');
            if (r == true) {
                var url = "{{ url('document-file-delete') }}/" + id;
                $.ajax({
                    method: "GET",
                    url: url,
                    dataType: "json"
                }).success(function (result) {
                    if (result == true)
                        $('#tr' + id).remove();
                });
            }
        }
    </script>
@endsection

