@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsPlaces.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($lawsPlace, ['route' => ['lawsPlaces.update', $lawsPlace->id], 'method' => 'patch','files' => true]) !!}
                @include('lawsPlaces.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection