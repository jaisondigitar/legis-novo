@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsTypes.show') !!}
@endsection
@section('content')
    @include('lawsTypes.show_fields')

    <div class="form-group">
           <a href="{!! route('lawsTypes.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
