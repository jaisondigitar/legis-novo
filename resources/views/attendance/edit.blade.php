@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('attendance.edit') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        @include('common.errors')
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($attendance, ['route' => ['attendance.update', $attendance->id], 'method' => 'patch','files' => true]) !!}
                @include('attendance.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
