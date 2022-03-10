@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.list') !!}
@endsection
@section('content')
    <div style="margin: 1rem 3.125rem 1rem 3.125rem" class="the-box rounded">
        <form method="GET">
            <div class="row">
                <div class="form-group col-md-2">
                    {!! Form::label('date_start', 'Data Inicial:') !!}
                    {!! Form::text('date_start', $form->input('date_start'), ['class' => 'form-control datepicker']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('date_end', 'Data Final:') !!}
                    {!! Form::text('date_end', $form->input('date_end'), ['class' => 'form-control datepicker']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('reg', 'Registro:') !!}
                    {!! Form::text('reg', $form->input('reg'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('proto', 'Protocolo:') !!}
                    {!! Form::text('proto', $form->input('proto'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('type', 'Tipo:') !!}
                    {!! Form::select('type', App\Models\LawsType::pluck('name', 'id')->prepend('Selecione...', '') ,$form->input('type'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('number', 'Número:') !!}
                    {!! Form::input('number', 'number', $form->input('number'), ['class' => 'form-control', 'min' => 0]) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('year', 'Ano:') !!}
                    {!! Form::input('number', 'year', $form->input('year'), ['class' => 'form-control', 'min' => 1000, 'max' => 9999]) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('owner_id', 'Responsável:') !!}
                    {!! Form::select('owner', $assemblymensList ,$form->input('owner'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-1">
                    {!! Form::label('pdf', 'Gerar PDF:') !!}
                    {!! Form::select('pdf', [0=>'Não', 1 => 'Sim'] ,$form->input('pdf'), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row" style="margin-top: 20px; text-align: start">
                <div class="form-group col-md-12">
                    <button class="btn btn-block btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                    <button type="reset" class="btn btn-block btn-warning"><i class="fa fa-recycle"></i> Reset</button>
                </div>
            </div>
        </form>
    </div>
    <div style="margin: 1rem 3.125rem 1rem 3.125rem" class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                @include('report.lawsProjectTable')
            </div>
        </div>
    </div>
@endsection
