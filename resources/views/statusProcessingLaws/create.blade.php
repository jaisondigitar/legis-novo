@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'statusProcessingLaws.store','files'=>true]) !!}
                @include('statusProcessingLaws.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
