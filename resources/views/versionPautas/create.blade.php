@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'version_pauta.store']) !!}
                @include('versionPautas.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
