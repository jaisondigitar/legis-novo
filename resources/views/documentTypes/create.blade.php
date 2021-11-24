@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documentTypes.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'documentTypes.store','files'=>true]) !!}
                @include('documentTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection