@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('attendance.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <form method="GET">
            <!-- Date Field -->
            <div class="form-group col-md-3">
                {!! Form::label('date', 'Data:') !!}
                {!! Form::text('date', $form->input('date'), ['class' => 'form-control datepicker']) !!}
            </div>

            <!-- Type Field -->
            <div class="form-group col-md-3">
                {!! Form::label('type_id', 'Tipo de Atendimento:') !!}
                {!! Form::select('type_id', $type, $form->input('type_id'), ['class' => 'form-control']) !!}
            </div>

            <!-- People Field -->
            <div class="form-group col-md-3">
                {!! Form::label('people_id', 'Visitante:') !!}
                {!! Form::select('people_id', $people, $form->input('people_id'), ['class' => 'form-control']) !!}
            </div>

            <!-- Sector Field -->
            <div class="form-group col-md-3">
                {!! Form::label('sector_id', 'Setor:') !!}
                {!! Form::select('sector_id', $sector, $form->input('sector_id'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-10">
                <button class="btn btn-block btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
            </div>
            <div class="form-group col-md-2">
                <button type="reset" class="btn btn-block btn-warning"><i class="fa fa-recycle"></i> Reset</button>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        @shield('attendance.create')
                            <a href="{!! route('attendance.create') !!}">
                                <button type="button" class="btn btn-default">
                                    <i class="fa fa-plus-circle"></i> Novo registro
                                </button>
                            </a>
                        @endshield
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                @if($attendance->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('attendance.table')
                @endif
            </div>
        </div>
    </div>
@endsection
