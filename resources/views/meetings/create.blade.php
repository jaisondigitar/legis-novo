@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('meetings.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'meetings.store','files'=>true]) !!}
                @include('meetings.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection