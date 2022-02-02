@extends('layouts.blit')

@section('content')
    @include('$ROUTES_AS_PREFIX$configs.show_fields')

    <div class="form-group">
           <a href="{!! route('$ROUTES_AS_PREFIX$configs.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
