@extends('layouts.blit')

@section('content')
    @include('advicePublicationDocuments.show_fields')

    <div class="form-group">
           <a href="{!! route('advicePublicationDocuments.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
