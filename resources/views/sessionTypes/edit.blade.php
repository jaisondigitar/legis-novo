@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sessionTypes.edit') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($sessionType, ['route' => ['sessionTypes.update', $sessionType->id], 'method' => 'patch','files' => true]) !!}
                @include('sessionTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
