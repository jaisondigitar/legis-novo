@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('parameters.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @extends('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($parameters, ['route' => ['parameters.update', $parameters->id], 'method' => 'patch','files' => true]) !!}
                @include('parameters.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection