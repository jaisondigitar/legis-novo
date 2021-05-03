@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsStructures.show') !!}
@endsection
@section('content')
    @include('lawsStructures.show_fields')

    <div class="form-group">
           <a href="{!! route('lawsStructures.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
