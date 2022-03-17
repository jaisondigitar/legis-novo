@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.new') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'documents.store','files'=>true]) !!}
                @include('documents.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
