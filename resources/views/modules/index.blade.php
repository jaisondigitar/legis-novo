@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills" style="margin-bottom: 10px">
                    <li><a href="{!! route('modules.create') !!}">Novo Registro</a></li>
                </ul>
            </div>
        </div>
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
