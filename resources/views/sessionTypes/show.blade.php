@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('sessionTypes.show') !!}
@endsection
@section('content')
    @include('sessionTypes.show_fields')

    <div class="form-group">
           <a href="{!! route('sessionTypes.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
