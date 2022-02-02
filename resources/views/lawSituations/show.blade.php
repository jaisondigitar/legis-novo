@extends('layouts.blit')

@section('content')
    @include('lawSituations.show_fields')

    <div class="form-group">
           <a href="{!! route('lawSituations.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
