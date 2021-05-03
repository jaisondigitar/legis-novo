@extends('layouts.blit')

@section('content')
    @include('$ROUTES_AS_PREFIX$advices.show_fields')

    <div class="form-group">
           <a href="{!! route('$ROUTES_AS_PREFIX$advices.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
