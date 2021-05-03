@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsPlaces.show') !!}
@endsection
@section('content')
    @include('lawsPlaces.show_fields')

    <div class="form-group">
           <a href="{!! route('lawsPlaces.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
