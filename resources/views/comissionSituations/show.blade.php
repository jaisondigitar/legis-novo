@extends('layouts.blit')

@section('content')
    @include('comissionSituations.show_fields')

    <div class="form-group">
           <a href="{!! route('comissionSituations.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
