@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('people.show') !!}
@endsection
@section('content')
    @include('people.show_fields')

    <div class="form-group">
        <a href="{!! route('people.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
