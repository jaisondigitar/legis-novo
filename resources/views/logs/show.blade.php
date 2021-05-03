@extends('layouts.blit')

@section('content')
    @include('logs.show_fields')

    <div class="form-group">
           <a href="{!! route('logs.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
