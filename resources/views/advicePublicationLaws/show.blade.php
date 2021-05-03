@extends('layouts.blit')

@section('content')
    @include('advicePublicationLaws.show_fields')

    <div class="form-group">
           <a href="{!! route('advicePublicationLaws.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
