@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'typeVotings.store','files'=>true]) !!}
                @include('typeVotings.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
