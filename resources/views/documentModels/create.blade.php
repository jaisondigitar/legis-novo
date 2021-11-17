@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documentModels.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'documentModels.store','files'=>true]) !!}
                @include('documentModels.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection