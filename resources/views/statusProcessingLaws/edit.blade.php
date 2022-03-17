@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($statusProcessingLaw, ['route' => ['statusProcessingLaws.update', $statusProcessingLaw->id], 'method' => 'patch','files' => true]) !!}
                @include('statusProcessingLaws.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
