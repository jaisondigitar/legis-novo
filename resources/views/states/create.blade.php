@extends('layouts.blit')
@section('title', 'Novo estado')
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
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
