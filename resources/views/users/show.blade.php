@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('users.show') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-info-circle"></i> Informações</h3>
                </div>
                <div class="panel-body">
                    @include('users.show_fields')
                </div><!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
@endsection
