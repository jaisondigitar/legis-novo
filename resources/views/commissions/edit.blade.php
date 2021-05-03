@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('commissions.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($commission, ['route' => ['commissions.update', $commission->id], 'method' => 'patch','files' => true]) !!}
                @include('commissions.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection