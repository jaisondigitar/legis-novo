@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documentModels.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($documentModels, ['route' => ['documentModels.update', $documentModels->id], 'method' => 'patch','files' => true]) !!}
                @include('documentModels.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection