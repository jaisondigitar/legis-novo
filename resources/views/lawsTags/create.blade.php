@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsTags.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'lawsTags.store','files'=>true]) !!}
                @include('lawsTags.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection