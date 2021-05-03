@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsTypes.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'lawsTypes.store','files'=>true]) !!}
                @include('lawsTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection