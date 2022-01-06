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
            @foreach($logs as $key => $log)
                <div class="col-sm-12" style="display: flex; margin: 20px 0;">
                    <div class="<?php echo $log->event; ?>"></div>
                    <div
                        class="col-sm-12 log"
                        @if($key%2==0)
                        style="border: 1px solid #ddd; background-color: #ddd;"
                        @else
                        style="border: 1px solid #ddd; background-color: #fff;"
                        @endif
                    >
                        <div>
                            <?php
                            $model = explode('\\', $log->auditable_type);
                            $table = strtoupper($model[2]);
                            $title = $translation[$table] ?? $table;

                            switch ($log->event) {
                                case 'created':
                                    echo "<label class='badge badge-success'>CRIOU</label>";
                                    break;
                                case 'updated':
                                    echo "<label class='badge badge-warning'>EDITOU</label>";
                                    break;
                                case 'deleted':
                                    echo "<label class='badge badge-danger'>DELETOU</label>";
                                    break;
                            }
                            echo '<br><div class="col-sm-12"><b>MODEL: </b>'.$title.'</div><br><br>';

                            echo '<p style="border: 1px solid #adadad"></p>';

                            echo '<div class="col-sm-3"><b>ID:</b> '.strtoupper($log->auditable_id).'</div>';
                            echo '<div class="col-sm-3"><b>Data</b>: '.date('d/m/Y H:i:s', strtotime($log->created_at)).'</div>';
                            echo '<div class="col-sm-5"><b>Rota:</b> '.$log->url.'</div>';
                            echo '<div class="col-sm-1"><b>IP:</b> '.$log->ip_address.'</div>';

                            echo '<p style="border: 1px solid #adadad; margin-top: 40px;"></p>';

                            if ($log->event == 'updated') {
                                echo '<div class="col-sm-6">';
                                echo '<strong>VALOR ANTIGO</strong><br><br>';
                                $object = json_decode($log->old_values);

                                foreach ($object as $key => $value) {
                                    $columns = $translation[$key] ?? $key;

                                    if ($key == 'date' || $key == 'date_start' || $key == 'date_end' || $key == 'law_date') {
                                        $newDate = date('d/m/Y', strtotime($value));
                                        echo '<strong>'.$columns.'</strong>: '.$newDate.'<br style="margin-bottom: 3px">';
                                    } else {
                                        echo '<strong>'.$columns.'</strong>: '.(is_object($value) ? '' : $value).'<br style="margin-bottom: 3px">';
                                    }
                                }
                                echo '</div>';
                            }

                            if ($log->event == 'updated' || $log->event == 'created') {
                                echo '<div class="col-sm-6">';
                                echo '<strong>NOVO VALOR</strong><br><br>';
                                $object = json_decode($log->new_values);

                                foreach ($object as $key => $value) {
                                    $columns = $translation[$key] ?? $key;

                                    if ($key == 'date' || $key == 'date_start' || $key == 'date_end' || $key == 'law_date') {
                                        $newDate = date('d/m/Y', strtotime($value));
                                        echo '<strong>'.$columns.'</strong>: '.$newDate.'<br style="margin-bottom: 3px">';
                                    } else {
                                        echo '<strong>'.$columns.'</strong>: '.(is_object($value) ? '' : $value).'<br style="margin-bottom: 3px">';
                                    }
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
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

