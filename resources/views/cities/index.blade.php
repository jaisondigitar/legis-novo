@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills" style="margin-bottom: 10px">
                    <li><a href="{!! route('cities.create') !!}">Novo Registro</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($cities->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('cities.table')
                @endif
            </div>
        </div>
        @include('common.paginate', ['records' => $cities])
    </div>
@endsection
