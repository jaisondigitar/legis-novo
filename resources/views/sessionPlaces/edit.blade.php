@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sessionPlaces.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($sessionPlace, ['route' => ['sessionPlaces.update', $sessionPlace->id], 'method' => 'patch','files' => true]) !!}
                @include('sessionPlaces.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection