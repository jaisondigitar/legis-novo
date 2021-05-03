@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('assemblymen.show') !!}
@endsection
@section('content')
    @include('assemblymen.show_fields')

    <div class="form-group">
           <a href="{!! route('assemblymen.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
