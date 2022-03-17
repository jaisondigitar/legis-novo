@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($adviceSituationDocuments, ['route' => ['adviceSituationDocuments.update', $adviceSituationDocuments->id], 'method' => 'patch','files' => true]) !!}
                @include('adviceSituationDocuments.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
