@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('destination.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
{{--                <div class="panel-heading">--}}
{{--                    <h3 class="panel-title">NOVO REGISTRO</h3>--}}
{{--                </div>--}}
                <div class="panel-body">
                    {!! Form::open(['route' => 'destinations.store','files' => true]) !!}
                        @include('destinations.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
