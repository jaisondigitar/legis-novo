@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sessionTypes.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($sessionType, ['route' => ['sessionTypes.update', $sessionType->id], 'method' => 'patch','files' => true]) !!}
                @include('sessionTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection