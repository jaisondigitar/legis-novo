@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsStructures.edit') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($lawsStructure, ['route' => ['lawsStructures.update', $lawsStructure->id], 'method' => 'patch','files' => true]) !!}
                @include('lawsStructures.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
