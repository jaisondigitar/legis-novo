@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('officeCommission.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'officeCommissions.store','files'=>true]) !!}
                @include('officeCommissions.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection