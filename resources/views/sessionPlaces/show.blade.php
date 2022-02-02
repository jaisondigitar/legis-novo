@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sessionPlaces.show') !!}
@endsection
@section('content')
    @include('sessionPlaces.show_fields')

    <div class="form-group">
           <a href="{!! route('sessionPlaces.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
