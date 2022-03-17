@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('responsibilities.edit') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($responsibility, ['route' => ['responsibilities.update', $responsibility->id], 'method' => 'patch','files' => true]) !!}
                @include('responsibilities.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
