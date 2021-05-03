@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('legislatures.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        @shield('legislatures.create')<a href="{!! route('legislatures.create') !!}">
                            <button type="button" class="btn btn-default"><i class="fa fa-plus-circle"></i> Novo registro</button>
                        </a>@endshield
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                @include('legislatures.table')
            </div>
        </div>
    </div>
@endsection