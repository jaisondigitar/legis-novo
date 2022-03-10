@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('responsibilities.list') !!}
@endsection
@section('content')
    <div style="margin: 1rem 3.125rem 1rem 3.125rem" class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        @shield('responsibilities.create')
                            <a href="{!! route('responsibilities.create') !!}">
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
                @if($responsibilities->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('responsibilities.table')
                @endif
            </div>
        </div>
    </div>
@endsection
