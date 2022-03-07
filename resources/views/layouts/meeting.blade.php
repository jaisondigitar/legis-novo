@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('meetings.show') !!}
@endsection
@section('content')
    <style>
        .menu, .list-group {
            text-decoration: none;
            color: #999;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="the-box text-center">
                    <ul class="list-group">
                        <li class="list-group-item text-left active">
                            @shield('meetings.show')<a href="{!! route('meetings.show', [$meeting->id]) !!}" class="menu" style="color: #fff;"><i class="fa fa-home"></i> INÍCIO</a>@endshield
                        </li>
                        <li class="list-group-item text-left">
                            @shield('meetings.edit')<a href="{!! route('meetings.newpauta', [$meeting->id]) !!}" class="menu"><i class="fa fa-book"></i> PAUTA</a>@endshield
                        </li>
                        <li class="list-group-item text-left">
                            @shield('meetings.edit')<a href="{!! route('meetings.newata', [$meeting->id]) !!}" class="menu"><i class="fa fa-file-text"></i> ATA</a>@endshield
                        </li>
                        <li class="list-group-item text-left">
                            @shield('meetings.edit')<a href="{!! route('meetings.presence', [$meeting->id]) !!}" class="menu"><i class="fa fa-users"></i> PRESENÇA</a>@endshield
                        </li>
                        <li class="list-group-item text-left">
                            @shield('meetings.edit')<a href="{!! route('meetings.voting', [$meeting->id]) !!}" class="menu"><i class="fa fa-list"></i> VOTAÇÃO</a>@endshield
                        </li>
                        <li class="list-group-item text-left">
                            @shield('meetings.edit')<a href="/painel-votacao/{{Auth::user()->company->stage}}" class="menu" target="_blank"><i class="fa fa-ticket"></i> PAINEL DE VOTAÇÃO</a>@endshield
                        </li>
                        <li class="list-group-item text-left">
                            @shield('meetings.edit')<a href="/meetings/{{$meeting->id}}/discourse" class="menu text-uppercase"><i class="fa fa-user "></i> PÚLPITO</a>@endshield
                        </li>
                        <li class="list-group-item text-left active">
                            <i class="fa fa-cog"></i> CONFIGURAÇÕES
                        </li>
                        <li class="list-group-item text-left">
                            @shield('meetings.edit')<a href="{!! route('voting.panelStage', $meeting->id) !!}" class="menu text-uppercase"><i class="fa fa-ticket "></i> Estado do painel</a>@endshield
                        </li>
                        <li class="list-group-item text-left">
                            <a href="{!! route('meetings.index')!!}" class="menu"><i class="fa fa-reply"></i> VOLTAR</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="the-box">
                    <h1>
                        SESSÃO
                        {{$meeting->number}}/{{Carbon\Carbon::createFromFormat('d/m/Y H:i',$meeting->date_start)->year}}
                    </h1>
                    <small>
                        {{$meeting->session_type->name}}
                    </small>
                    <hr/>
                    <div>
                        @yield('content-meeting')

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
