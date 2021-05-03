@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('parties.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('core-templates::common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($party, ['route' => ['parties.update', $party->id], 'method' => 'patch','files' => true]) !!}
                @include('parties.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection