@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documentTypes.new') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
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
