@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('destination.list') !!}
@endsection
@section('content')
    <div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills" style="margin-bottom: 10px">
                    <a href="{!! route('destinations.create') !!}">
                        <button type="button" class="btn btn-default">
                            <i class="fa fa-plus-circle"></i> Novo registro
                        </button>
                    </a>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($destinations->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('destinations.table')
                @endif
            </div>
        </div>
        @include('common.paginate', ['records' => $destinations])
    </div>
@endsection
