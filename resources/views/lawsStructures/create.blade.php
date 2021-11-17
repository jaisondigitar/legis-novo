@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsStructures.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'lawsStructures.store','files'=>true]) !!}
                @include('lawsStructures.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection