@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @extends('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'documents.store','files'=>true]) !!}
                @include('documents.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection