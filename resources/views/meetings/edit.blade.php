@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('meetings.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($meeting, ['route' => ['meetings.update', $meeting->id], 'method' => 'patch','files' => true]) !!}
                @include('meetings.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection