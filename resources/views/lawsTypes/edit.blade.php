@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsTypes.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($lawsType, ['route' => ['lawsTypes.update', $lawsType->id], 'method' => 'patch','files' => true]) !!}
                @include('lawsTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection