@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsPlaces.edit') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($lawsPlace, ['route' => ['lawsPlaces.update', $lawsPlace->id], 'method' => 'patch','files' => true]) !!}
                @include('lawsPlaces.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
