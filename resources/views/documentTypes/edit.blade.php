@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documentTypes.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($documentType, ['route' => ['documentTypes.update', $documentType->id], 'method' => 'patch','files' => true]) !!}
                @include('documentTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection