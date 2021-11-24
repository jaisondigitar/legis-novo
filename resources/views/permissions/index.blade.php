@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        <a href="{!! route('permissions.create') !!}">
                            <button type="button" class="btn btn-default"><i class="fa fa-plus-circle"></i> Novo registro</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr">
        <div class="row">
            <div class="col-md-12">
                @if($permissions->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('permissions.table')
                @endif
            </div>
        </div>

    </div>
@endsection