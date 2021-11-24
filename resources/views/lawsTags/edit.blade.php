@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsTags.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($lawsTag, ['route' => ['lawsTags.update', $lawsTag->id], 'method' => 'patch','files' => true]) !!}
                @include('lawsTags.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection