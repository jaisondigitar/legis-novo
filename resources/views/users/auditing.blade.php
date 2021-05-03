@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('users.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <h1>Logs do usuario - {{ $user->name }}</h1>
                <p>E-mail: {{ $user->email }}</p>
                @include('users.table_logs')
            </div>
        </div>
    </div>
@endsection