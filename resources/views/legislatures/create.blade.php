@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('legislatures.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'legislatures.store','files'=>true]) !!}
                @include('legislatures.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection