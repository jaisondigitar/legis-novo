@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('attendance.new') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        @include('common.errors')
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['route' => 'attendance.store','files'=>true]) !!}
                @include('attendance.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
