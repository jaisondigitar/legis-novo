@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.show') !!}
@endsection
@section('content')
    @include('lawsProjects.show_fields')

    <div class="form-group">
           <a href="{!! route('lawsProjects.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
