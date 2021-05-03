@extends('layouts.blit')
@section('title', 'Editar estado')
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
        {!! Form::model($state, ['route' => ['states.update', $state->id], 'method' => 'patch','files' => true]) !!}
        @include('states.fields')
        {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection