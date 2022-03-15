@extends('layouts.blit')

@section('Breadcrumbs')
    {!! Breadcrumbs::render('assemblymen.list') !!}
@endsection

@section('content')
    <div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        @shield('assemblymen.create')
                            <a href="{!! route('assemblymen.create') !!}">
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
                @if($assemblymen->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('assemblymen.table')
                @endif
            </div>
        </div>
    </div>
@endsection
