@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('people.edit') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        @include('common.errors')
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($people, ['route' => ['people.update', $people->id], 'method' => 'patch','files' => true]) !!}
                @include('people.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
