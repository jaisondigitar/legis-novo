@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documentTypes.show') !!}
@endsection
@section('content')
    @include('documentTypes.show_fields')

    <div class="form-group">
           <a href="{!! route('documentTypes.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
