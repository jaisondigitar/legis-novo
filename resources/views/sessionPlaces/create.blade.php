@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sessionPlaces.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'sessionPlaces.store','files'=>true]) !!}
                @include('sessionPlaces.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection