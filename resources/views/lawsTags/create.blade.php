@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsTags.new') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'lawsTags.store','files'=>true]) !!}
                @include('lawsTags.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
