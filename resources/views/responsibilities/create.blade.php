@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('responsibilities.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'responsibilities.store','files'=>true]) !!}
                @include('responsibilities.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection