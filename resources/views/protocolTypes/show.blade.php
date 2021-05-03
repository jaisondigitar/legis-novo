@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('protocolTypes.show') !!}
@endsection
@section('content')
    @include('protocolTypes.show_fields')

    <div class="form-group">
           <a href="{!! route('protocolTypes.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
