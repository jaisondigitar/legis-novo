@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('parameters.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'parameters.store','files'=>true]) !!}
                @include('parameters.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection