@extends('layouts.blit')
@section('title', 'Profiles')
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills" style="margin-bottom: 10px">
                    <li><a href="{!! route('profiles.create') !!}">Novo Registro</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($profiles->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('profiles.table')
                @endif
            </div>
        </div>
        @include('common.paginate', ['records' => $profiles])

    </div>
@endsection