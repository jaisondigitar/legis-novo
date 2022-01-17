@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('typesOfAttendance.show') !!}
@endsection
@section('content')
    @include('typesOfAttendance.show_fields')

    <div class="form-group">
        <a href="{!! route('typesOfAttendance.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
