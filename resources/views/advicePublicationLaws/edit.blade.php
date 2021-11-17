@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($advicePublicationLaw, ['route' => ['advicePublicationLaws.update', $advicePublicationLaw->id], 'method' => 'patch','files' => true]) !!}
                @include('advicePublicationLaws.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection