@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('responsibilities.show') !!}
@endsection
@section('content')
    @include('responsibilities.show_fields')

    <div class="form-group">
           <a href="{!! route('responsibilities.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
