@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'types.store','files'=>true]) !!}
                @include('types.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
