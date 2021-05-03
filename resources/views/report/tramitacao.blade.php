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
                        <a href="/report/tamitacao/pdf" target="_blank" class="btn btn-success"> Gerar PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="col-md-12">
                <table class="table table-responsive" id="lawsProjects-table">
                    <thead>
                    <th>id</th>
                    <th>COD</th>
                    <th>Numero Projeto de lei</th>
                    <th>Numero da lei</th>
                    <th>Tipo</th>
                    </thead>
                    <tbody>
                    @foreach($tramitacao as $item)
                        @if($item->getNumberLaw() != 'false')
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{!! $item->getNumberLaw() !!}</td>
                            <td>{!! $item->project_number !!}</td>
                            <td>{!! $item->law_number !!}</td>
                            <td>{!! $item->law_type->name !!}</td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>



@endsection