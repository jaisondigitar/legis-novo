@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body">
                    {!! Form::model($module, ['route' => ['modules.update', $module->id], 'method' => 'patch','files' => true]) !!}
                    @include('modules.fields')
                    {!! Form::close() !!}
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection
