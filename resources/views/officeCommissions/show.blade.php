@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('officeCommission.show') !!}
@endsection
@section('content')
    @include('officeCommissions.show_fields')

    <div class="form-group">
           <a href="{!! route('officeCommissions.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
