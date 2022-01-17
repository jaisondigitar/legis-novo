@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('attendance.show') !!}
@endsection
@section('content')
    @include('attendance.show_fields')

    <div class="form-group">
        <a href="{!! route('attendance.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
