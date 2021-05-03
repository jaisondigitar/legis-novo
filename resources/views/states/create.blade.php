@extends('layouts.blit')
@section('title', 'Novo estado')
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
        {!! Form::open(['route' => 'states.store','files' => true]) !!}
        @include('states.fields')
        {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
