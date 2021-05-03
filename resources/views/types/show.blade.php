@extends('layouts.blit')

@section('content')
    @include('types.show_fields')

    <div class="form-group">
           <a href="{!! route('types.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
