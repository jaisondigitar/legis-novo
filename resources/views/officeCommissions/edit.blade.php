@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('officeCommission.edit') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($officeCommission, ['route' => ['officeCommissions.update', $officeCommission->id], 'method' => 'patch','files' => true]) !!}
                @include('officeCommissions.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
