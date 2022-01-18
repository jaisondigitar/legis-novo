@extends('layouts.blit')

@section('content')
    @include('documentSituations.show_fields')

    <div class="form-group">
           <a href="{!! route('documentSituations.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
