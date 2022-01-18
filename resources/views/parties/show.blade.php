@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('parties.show') !!}
@endsection
@section('content')
    @include('parties.show_fields')

    <div class="form-group">
           <a href="{!! route('parties.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
