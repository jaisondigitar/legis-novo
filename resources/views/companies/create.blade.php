@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('company.new') !!}
@endsection
@section('content')
<div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
                <div class="panel-body">
                    {!! Form::open(['route' => 'companies.store','files' => true]) !!}
                    @include('companies.fields')
                    {!! Form::close() !!}
                </div><!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
@endsection
