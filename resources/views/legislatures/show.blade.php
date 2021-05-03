@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('legislatures.show') !!}
@endsection
@section('content')
    <br>
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                @include('legislatures.show_fields')
            </div>
        </div>
    </div>
    <div class="form-group">
           <a href="{!! route('legislatures.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
