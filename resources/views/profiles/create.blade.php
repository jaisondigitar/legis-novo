@extends('layouts.blit')
@section('title', 'Nova profiles')
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">NOVO REGISTRO</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'profiles.store','files' => true]) !!}
                    @include('profiles.fields')
                    {!! Form::close() !!}
                </div><!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
@endsection
