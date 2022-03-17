@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('typesOfAttendance.edit') !!}
@endsection
@section('content')
    <div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
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
