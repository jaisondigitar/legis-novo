@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('responsibilities.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($responsibility, ['route' => ['responsibilities.update', $responsibility->id], 'method' => 'patch','files' => true]) !!}
                @include('responsibilities.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection