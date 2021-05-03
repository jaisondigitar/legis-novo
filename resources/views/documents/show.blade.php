@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.show') !!}
@endsection
@section('content')
    <div class="form-group">
        <a href="{!! route('documents.index') !!}" class="btn btn-default"> Voltar</a>
    </div>
    {{--@include('documents.show_fields')--}}
    <?php  ?>
@endsection
