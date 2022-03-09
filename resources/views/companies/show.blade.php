@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('company.show') !!}
@endsection
@section('content')
<div class="panel">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel panel-heading">
{{--                    <h3 class="panel-title"><i class="glyphicon glyphicon-dashboard"></i> INFORMAÇÕES </h3>--}}
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills" style="margin-bottom: 10px">
                        <li><a href="{!! route('companies.edit', [$company->id]) !!}">Editar Registro</a></li>
                    </ul>
                    @include('companies.show_fields')
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div  style="background-color: #e8e9ee" class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-cogs"></i> PARÂMETROS
                    </h3>
                </div>
                <div class="panel-body">
                    @include('companies.rotines')
                </div><!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
@endsection
