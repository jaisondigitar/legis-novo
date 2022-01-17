@extends('layouts.blit')

@section('content')
    @include('statusProcessingDocuments.show_fields')

    <div class="form-group">
           <a href="{!! route('statusProcessingDocuments.index') !!}" class="btn btn-default">Voltar</a>
    </div>
@endsection
