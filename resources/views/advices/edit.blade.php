@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($advice, ['route' => ['$ROUTES_AS_PREFIX$advices.update', $advice->id], 'method' => 'patch','files' => true]) !!}
                @include('$ROUTES_AS_PREFIX$advices.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
