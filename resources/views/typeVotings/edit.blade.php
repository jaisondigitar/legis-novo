@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($type_voting, ['route' => ['typeVotings.update', $type_voting->id], 'method' => 'patch','files' => true]) !!}
                @include('typeVotings.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
