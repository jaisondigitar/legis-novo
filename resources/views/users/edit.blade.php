@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('users.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">EDITAR REGISTRO</h3>
                </div>
                <div class="panel-body">
                    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch','files' => true]) !!}
                    @include('users.fields')
                    {!! Form::close() !!}
                </div><!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
@endsection
