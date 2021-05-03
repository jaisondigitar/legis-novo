@extends('layouts.blit')

@section('content')
    @include('typeVotings.show_fields')

    <div class="form-group">
           <a href="{!! route('typeVotings.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
