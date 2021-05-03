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
                        <a href="/report/pdf/noFilesLaw" target="_blank" class="btn btn-success"> Gerar PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="col-md-12">
                <table class="table table-responsive" id="lawsProjects-table">
                    <thead>
                    <th>#COD</th>
                    <th>DESCRIÇÃO</th>
                    <th>DATA</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($lawsProjects as $lawsProject)
                        <tr>
                            <td>{!! $lawsProject->getNumberLaw() !!}</td>

                            <td>
                                @if(!$lawsProject->law_type) {{ $lawsProject->law_type_id }} @else {!! mb_strtoupper($lawsProject->law_type->name, 'UTF-8') !!} @endif
                                <span id="tdLawProjectNumber{{$lawsProject->id}}">
                                    {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!}
                                </span>
                            </td>
                            <td> {{$lawsProject->law_date}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>



@endsection