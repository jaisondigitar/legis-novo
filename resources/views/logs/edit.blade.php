@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($log, ['route' => ['logs.update', $log->id], 'method' => 'patch','files' => true]) !!}
                @include('logs.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection