@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('advicePublicationLaws.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        @shield('advicePublicationLaws.create')
                            <a href="{!! route('advicePublicationLaws.create') !!}">
                                <button type="button" class="btn btn-default">
                                    <i class="fa fa-plus-circle"></i> Novo registro
                                </button>
                            </a>
                        @endshield
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                @if($advicePublicationLaws->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('advicePublicationLaws.table')
                @endif
            </div>
        </div>
    </div>
@endsection
