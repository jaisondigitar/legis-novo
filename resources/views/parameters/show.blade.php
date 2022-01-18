@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('parameters.show') !!}
@endsection
@section('content')
    @include('parameters.show_fields')

    <div class="form-group">
           <a href="{!! route('parameters.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
