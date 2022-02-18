@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('users.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills" style="margin-bottom: 10px">
                    @shield('users.create')
                        <li>
                            <a href="{!! route('users.create') !!}">
                                <button type="button" class="btn btn-default">
                                    <i class="fa fa-plus-circle"></i> Novo registro
                                </button>
                            </a>
                        </li>
                    @endshield
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($users->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('users.table')
                @endif
            </div>
        </div>
        @include('common.paginate', ['records' => $users])
    </div>
@endsection
