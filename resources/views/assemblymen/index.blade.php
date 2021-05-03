@extends('layouts.blit')

@section('Breadcrumbs')
    {!! Breadcrumbs::render('assemblymen.list') !!}
@endsection

@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        @shield('assemblymen.create')<a href="{!! route('assemblymen.create') !!}">
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
                @include('assemblymen.table')
            </div>
        </div>

    </div>
@endsection
