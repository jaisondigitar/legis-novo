@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documentModels.show') !!}
@endsection
@section('content')
    @include('documentModels.show_fields')

    <div class="form-group">
           <a href="{!! route('documentModels.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
