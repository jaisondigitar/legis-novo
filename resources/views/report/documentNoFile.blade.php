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
                        <a href="/report/pdf/noFiles" target="_blank" class="btn btn-success"> Gerar PDF</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <br>
            <div class="col-md-12">
                @if($documents->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    <table class="table table-responsive" id="documents-table">
                        <thead>
                            <tr>
                                <th>Número interno</th>
                                <th style="text-align: center">Número</th>
                                <th>Data</th>
                                <th>Tipo documento</th>
                                <th>Responsável</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                                <tr id="row_{{$document->id}}" >
                                    <td>{!! $document->getNumber() !!}</td>
                                    <td id="tdnumber{{$document->id}}" style="text-align: center">
                                        @if($document->number==0)
                                            -
                                        @else
                                            {!! $document->number . '/' . $document->getYear($document->date) !!}
                                        @endif
                                    </td>
                                    <td>{!! $document->date !!}</td>
                                    <td>@if($document->document_type->parent_id) {{ $document->document_type->parent->name }} ::  @endif {!! $document->document_type->name !!}</td>
                                    <td>
                                        @if($document->owner) {!! $document->owner->short_name !!} @else - @endif
                                        @if($document->assemblyman()->count() > 0)
                                            @foreach($document->assemblyman()->get() as $assemblyman)
                                                - {{$assemblyman->short_name}}
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
