@extends('layouts.blit')

@section('content')
    @include('$ROUTES_AS_PREFIX$statusProcessingLaws.show_fields')

    <div class="form-group">
           <a href="{!! route('statusProcessingLaws.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
