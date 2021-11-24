@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('typesOfAttendance.new') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        @include('common.errors')
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['route' => 'typesOfAttendance.store','files'=>true]) !!}
                @include('typesOfAttendance.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
