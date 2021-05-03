@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsStructures.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($lawsStructure, ['route' => ['lawsStructures.update', $lawsStructure->id], 'method' => 'patch','files' => true]) !!}
                @include('lawsStructures.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection