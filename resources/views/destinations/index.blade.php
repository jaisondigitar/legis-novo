@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('destination.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills" style="margin-bottom: 10px">
                    <li><a href="{!! route('destinations.create') !!}">Novo Registro</a></li>
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
