@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('parties.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'parties.store','files'=>true]) !!}
                @include('parties.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection