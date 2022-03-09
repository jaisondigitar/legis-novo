@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('destination.show') !!}
@endsection
@section('content')
<div class="panel">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel panel-heading">
{{--                    <h3 class="panel-title"><i class="glyphicon glyphicon-dashboard"></i>INFORMAÇÕES</h3>--}}
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills" style="margin-bottom: 10px">
                        <li>
                            <a style="color:black" href="{!! route('destinations.edit', [$destination->id]) !!}">
                                Editar Registro
                            </a>
                        </li>
                    </ul>
                    @include('destinations.show_fields')
                </div>
            </div>
        </div>
        {{--<div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-cogs"></i>PARÂMETROS
                    </h3>
                </div>
                <div class="panel-body">
                    @include('destinations.rotines')
                </div>
            </div>
        </div>--}}
    </div>
</div>
@endsection
