@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sectors.show') !!}
@endsection
@section('content')
    @include('sectors.show_fields')

    <div class="form-group">
           <a href="{!! route('sectors.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
