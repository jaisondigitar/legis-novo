@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('commissions.new') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'commissions.store','files'=>true]) !!}
                @include('commissions.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection