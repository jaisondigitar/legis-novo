@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('protocolTypes.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($protocolType, ['route' => ['protocolTypes.update', $protocolType->id], 'method' => 'patch','files' => true]) !!}
                @include('protocolTypes.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection