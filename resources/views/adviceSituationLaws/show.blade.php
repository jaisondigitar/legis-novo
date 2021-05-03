@extends('layouts.blit')

@section('content')
    @include('adviceSituationLaws.show_fields')

    <div class="form-group">
           <a href="{!! route('adviceSituationLaws.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
