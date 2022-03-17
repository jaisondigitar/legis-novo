@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('assemblymen.edit') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($assemblyman, ['route' => ['assemblymen.update', $assemblyman->id], 'method' => 'patch','files' => true]) !!}
                @include('assemblymen.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
