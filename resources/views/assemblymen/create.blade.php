@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('assemblymen.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'assemblymen.store','files'=>true]) !!}
                @include('assemblymen.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection