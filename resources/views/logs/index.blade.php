@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
    <div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
        <form method="GET">
            <div class="row">
                <div class="form-group col-md-4">
                    {!! Form::label('user_id', 'Usuário:') !!}
                    {!! Form::select('user_id', App\Models\User::where('company_id',
                    \Illuminate\Support\Facades\Auth::user()->company_id)->pluck('name', 'id')
                    ->prepend('Selecione...', '') ,$form->input('user_id'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('auditable_type', 'Tabela:') !!}
                    {!! Form::select('auditable_type', $models ,$form->input('auditable_type'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-md-2">
                    {!! Form::label('event', 'Ação:') !!}
                    {!! Form::select('event', $type ,$form->input('type'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-md-2">
                    {!! Form::label('date', 'Ano:') !!}
                    {!! Form::text('year', $form->input('year'), ['class' => 'form-control datepicker']) !!}
                </div>

                <div class="clearfix"></div>

                <div class="col-lg-12" style="text-align: start">
                    <div class="form-group col-md mt-3">
                        <button class="btn btn-block btn-primary">
                            <i class="fa fa-search"></i>Pesquisar
                        </button>
                        <button type="reset" class="btn btn-block btn-warning">
                            <i class="fa fa-recycle"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="the-box rounded">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                @if($logs->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('logs.table')
                @endif
            </div>
        </div>
    </div>
@endsection
