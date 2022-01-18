@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsTags.show') !!}
@endsection
@section('content')
    @include('lawsTags.show_fields')

    <div class="form-group">
           <a href="{!! route('lawsTags.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
