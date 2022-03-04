@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        <a href="/report/pdf/noFilesLaw" target="_blank" class="btn btn-default"> Gerar PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="col-md-12">
                @if($lawsProjects->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    <table class="table table-striped table-hover" id="lawsProjects-table">
                        <thead>
                            <tr>
                                <th>#COD</th>
                                <th>DESCRIÇÃO</th>
                                <th>DATA</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lawsProjects as $lawsProject)
                                <tr>
                                    <td>{!! $lawsProject->getNumberLaw() !!}</td>
                                    <td>
                                        @if(!$lawsProject->law_type)
                                            {{ $lawsProject->law_type_id }}
                                        @else
                                            {!! mb_strtoupper($lawsProject->law_type->name, 'UTF-8') !!}
                                        @endif
                                        <span id="tdLawProjectNumber{{$lawsProject->id}}">
                                            {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!}
                                        </span>
                                    </td>
                                    <td>{{$lawsProject->law_date}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
