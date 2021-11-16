@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
<h4 class="text-uppercase">
    Anexos - @if(!$lawsProject->law_type) {{ $lawsProject->law_type_id }} @else {!! mb_strtoupper($lawsProject->law_type->name, 'UTF-8') !!} @endif
    <span id="tdLawProjectNumber{{$lawsProject->id}}">
        {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!}
    </span>
    <a href="{!! route('lawsProjects.index') !!}" class="btn btn-default  pull-right" style="margin-top: 5px;">Voltar</a>
</h4>
    <hr>
    <div class="col-md-12">
        <div class="the-box rounded">
            <div class="row">
                <div class="col-md-3">
                    @include('flash::message')
                    @shield('lawsProjects.upload')
                        {!! Form::open(['route' => ['lawsProjects.attachament.upload', $lawsProject->id], 'method' => 'post', 'files' => 'true']) !!}
                        <label class="control-label">Selecione o arquivo:</label>
                        {!! Form::file('file[]', array('multiple'=>true, 'class' => 'file')) !!}
                        <button type="submit" class="btn btn-success pull-right">Incluir</button>
                        {!! Form::close() !!}
                        <br>
                    @endshield
                    <hr class="hr">
                </div>
                <div class="col-md-9">
                    <h4 align="center">Anexos:</h4>
                    <table class="table table-bordered table-striped">
                        @foreach($law_files as $file)
                            <tr id="tr{{$file->id}}">
                                <td width="80%">{{ $file->filename }}</td>
                                <td align="center">
                                    <a href="{{ url('download-law/' .$file->filename. '/id/' . $file->law_project_id ) }}">
                                        <span class="label label-info">Download</span>
                                    </a>
                                    @shield('lawsProjects.upload')
                                        <a style="text-decoration: none" id="delFile" onclick="deleteFile({{$file->id}})">
                                            <span class="label label-danger">Excluir</span>
                                        </a>
                                    @endshield
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>

<script>
    function deleteFile(id) {
        var r = confirm('Deseja realmente apagar?');
        if (r == true) {
            var url = "{{ url('law-file-delete') }}/" + id;
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