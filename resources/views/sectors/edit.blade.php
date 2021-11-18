@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sectors.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($sector, ['route' => ['sectors.update', $sector->id], 'method' => 'patch','files' => true]) !!}
                @include('sectors.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection