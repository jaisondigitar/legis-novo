@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsPlaces.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'lawsPlaces.store','files'=>true]) !!}
                @include('lawsPlaces.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection