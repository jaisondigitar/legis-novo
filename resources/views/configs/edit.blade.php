@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($config, ['route' => ['$ROUTES_AS_PREFIX$configs.update', $config->id], 'method' => 'patch','files' => true]) !!}
                @include('$ROUTES_AS_PREFIX$configs.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection