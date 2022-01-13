@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <form method="GET">
            <div class="form-group col-md-2">
                {!! Form::label('date_start', 'Data Inicial:') !!}
                {!! Form::text('date_start', $form->input('date_start'), ['class' => 'form-control datepicker' , 'id' => 'date_start']) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('date_end', 'Data Final:') !!}
                {!! Form::text('date_end', $form->input('date_end'), ['class' => 'form-control datepicker' , 'id' => 'date_end']) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('reg', 'Registro:') !!}
                {!! Form::text('reg', $form->input('reg'), ['class' => 'form-control' , 'id' => 'reg']) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('proto', 'Protocolo:') !!}
                {!! Form::text('proto', $form->input('proto'), ['class' => 'form-control' , 'id' => 'proto']) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('date', 'Número:') !!}
                {!! Form::text('number', $form->input('number'), ['class' => 'form-control', 'id' => 'numero']) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('date', 'Ano:') !!}
                {!! Form::text('year', $form->input('year'), ['class' => 'form-control', 'id' => 'ano']) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('pdf', 'Gerar PDF') !!}
                {!! Form::select('pdf',[0 => 'Não', 1 => 'Sim'],$form->input('pdf'), ['class' => 'form-control', 'id' => 'pdf']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('owner_id', 'Tipo:') !!}
                {!! Form::select('type', App\Models\DocumentType::pluck('name', 'id')->prepend('Selecione...', '') ,$form->input('type'), ['class' => 'form-control' , 'id' => 'tipo']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('owner_id', 'Responsável') !!}
                {!! Form::select('owner', $assemblymensList ,$form->input('owner'), ['class' => 'form-control', 'id' => 'dono']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('date', 'Que contenha (texto):') !!}
                {!! Form::text('text', $form->input('text'), ['class' => 'form-control', 'id' => 'data']) !!}
            </div>

            <div class="clearfix"></div>

            <div class="form-group col-md-2 pull-right">
                <button class="btn btn-block btn-primary" ><i class="fa fa-search"></i> Pesquisar</button>
            </div>
            <div class="form-group col-md-2 pull-right">
                <button type="reset" class="btn btn-block btn-warning"><i class="fa fa-recycle"></i> Reset</button>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
    <div class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                @if($documents->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('flash::message')
                    @include('report.documentTable')
                @endif
            </div>
        </div>
    </div>
@endsection
