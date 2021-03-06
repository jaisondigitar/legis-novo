@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-dashboard"></i>  INFORMAÇÕES</h3>
                </div>
                <div class="panel-body">
                    @include('cities.show_fields')
                </div><!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
@endsection
