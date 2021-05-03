@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('commissions.show') !!}
@endsection
@section('content')
    @include('commissions.show_fields')

    <div class="form-group">
           <a href="{!! route('commissions.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
