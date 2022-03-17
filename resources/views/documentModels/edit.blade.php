@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documentModels.edit') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
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
