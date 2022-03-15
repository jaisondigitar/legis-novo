@extends('layouts.blit')
@section('title', 'Estados')
@section('content')
    <div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
        <div class="row">
            <a class="btn btn-success pull-left" style="margin: 10px" href="{!! route('states.create') !!}">Novo registro</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($states->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('states.table')
                @endif
            </div>
        </div>
        @include('common.paginate', ['records' => $states])
    </div>
@endsection
