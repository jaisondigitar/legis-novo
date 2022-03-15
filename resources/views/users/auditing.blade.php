@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('users.list') !!}
@endsection
@section('content')
    <div style="margin: 1rem 3.125rem 1rem 3.125rem" class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <h4>Logs do usuário - {{ $user->name }}</h4>
                <p>E-mail: {{ $user->email }}</p>
                @include('users.table_logs')
            </div>
        </div>
    </div>
@endsection
