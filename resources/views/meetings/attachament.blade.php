@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('meetings.attachment') !!}
@endsection
@section('content')
{{--    <a href="{{ url('meetings') }}" ><button type="button" class="btn btn-default" style="margin-bottom: 10px; color: #0A0A0A"><i class="fa fa-chevron-left"></i>Voltar</button></a>--}}
    <div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
        <div class="row">
            <div class="col-md-3">
                @include('flash::message')
                {!! Form::open(['route' => ['meetings.attachament.upload', $meeting->id], 'method' => 'post', 'files' => 'true']) !!}
                    <label class="control-label">Selecione o arquivo:</label>
                        {!! Form::file('file[]', array('multiple'=>true, 'class' => 'form-control')) !!}
                    <button type="submit" class="btn btn-success mt-2">Incluir</button>
                <a href="{!! route('meetings.index') !!}" class="btn btn-default mt-2">Cancelar</a>
                {!! Form::close() !!}
                <br>
            </div>
            <div class="col-md-9">
                <h4 align="center">Anexos:</h4>
                <table class="table table-bordered table-striped">
                    @foreach($meeting_files as $file)
                        <tr id="tr{{$file->id}}">
                            <td width="80%">{{ $file->filename }}</td>
                            <td align="center">
                                <a target="_blank" href="{{ (new \App\Services\StorageService())
                                ->inMeetingsFolder()->getPath($file->filename) }}">
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
    <script>
        function deleteFile(id) {

            var r = confirm('Deseja realmente apagar?');
            if (r == true) {
                var url = "{{ url('/meetings-file-delete') }}/" + id;
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

