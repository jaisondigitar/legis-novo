@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('protocolTypes.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'protocolTypes.store','files'=>true]) !!}
                @include('protocolTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection