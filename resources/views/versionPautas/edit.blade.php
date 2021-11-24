@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($version_pauta, ['route' => ['version_pauta.update', $version_pauta->id], 'method' => 'patch','files' => true]) !!}
                @include('versionPautas.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection