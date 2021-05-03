@extends('layouts.blit')

@section('content')
    @include('adviceSituationDocuments.show_fields')

    <div class="form-group">
           <a href="{!! route('adviceSituationDocuments.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
