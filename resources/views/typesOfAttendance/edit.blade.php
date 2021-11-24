@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('typesOfAttendance.edit') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        @include('common.errors')
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($types_of_attendance, ['route' => ['typesOfAttendance.update', $types_of_attendance->id], 'method' => 'patch','files' => true]) !!}
                @include('typesOfAttendance.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
