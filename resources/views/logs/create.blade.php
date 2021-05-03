@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'logs.store','files'=>true]) !!}
                @include('logs.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection