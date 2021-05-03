@extends('layouts.blit')
@section('title', 'profiles')
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-dashboard"></i>  INFORMAÇÕES</h3>
                </div>
                <div class="panel-body">
                    @include('profiles.show_fields')
                </div><!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
@endsection
