@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sessionTypes.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'sessionTypes.store','files'=>true]) !!}
                @include('sessionTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection