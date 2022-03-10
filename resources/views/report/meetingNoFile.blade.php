@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.list') !!}
@endsection
@section('content')
    <div style="margin: 1rem 3.125rem 1rem 3.125rem" class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        <a href="/report/pdf/noFilesMeeting" target="_blank" class="btn btn-default"> Gerar PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="col-md-12">
                @if($meetingFiles->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    <table class="table table-striped table-hover" id="lawsProjects-table">
                        <thead>
                            <tr>
                                <th>Nº Sessão</th>
                                <th>Tipo Sessão</th>
                                <th>Local Sessão</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetingFiles as $meetingFile)
                                <tr>
                                    <td>{!! $meetingFile->meeting->number !!}</td>
                                    <td>{!! $meetingFile->meeting->session_type->name !!}</td>
                                    <td>{!! $meetingFile->meeting->session_place->name !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
