@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
    <div style="margin: 1rem 3.125rem 1rem 3.125rem" class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        <a href="{!! route('modules.create') !!}">
                            <button type="button" class="btn btn-default">
                                <i class="fa fa-plus-circle"></i> Novo registro
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr">
        <div class="row">
            <div class="col-md-12">
                @if($modules->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('modules.table')
                @endif
            </div>
        </div>
        @include('common.paginate', ['records' => $modules])
    </div>
@endsection
