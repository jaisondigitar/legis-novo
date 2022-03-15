@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.list') !!}
@endsection
@section('content')
    <div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
        <form id="search-form" method="GET">
            <input type="hidden" name="has-filter" value="true">
            <div class="row">
                <div class="form-group col-md-2">
                    {!! Form::label('date', 'Data:') !!}
                    {!!
                        Form::text('reg', $form->input('reg'), [
                            'class' => 'form-control datepicker text-center'
                        ])
                    !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('owner_id', 'Tipo:') !!}
                    {!! Form::select(
                        'document_type_id',
                        App\Models\DocumentType::pluck('name', 'id')
                            ->prepend('Selecione...', ''),
                        $form->input('owner_id'), ['class' => 'form-control'])
                    !!}
                </div>
                <div class="form-group col-md-1">
                    {!! Form::label('date', 'Número:') !!}
                    {!! Form::input('number', 'number', $form->input('number'), ['class' => 'form-control', 'min' => 0]) !!}
                </div>
                <div class="form-group col-md-1">
                    {!! Form::label('date', 'Ano:') !!}
                    {!! Form::input('number', 'date', $form->input('date'), ['class' => 'form-control', 'min' => 1000, 'max' => 9999]) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('owner_id', 'Responsável:') !!}
                    {!! Form::select('owner_id', $assemblymensList, $form->input('owner_id'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('date', 'Que contenha (texto):') !!}
                    {!! Form::text('content', $form->input('content'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('status', 'Status:') !!}
                    {!! Form::select('status', [0 => 'Selecione...', 1 => 'Aberto', 2 =>
                    'Protocolado'], $form->input('status'), ['class' => 'form-control']) !!}
                </div>
            </div>

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
        </form>
    </div>

    <div style="margin: 1% 2.7% 1% 2.7%" class="the-box rounded">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        @shield('documents.delete')
                            <a href="javascript:void(0)" onclick="deletaBash()" style="display: none;" class="deleteAll">
                                <button type="button" class="btn btn-danger">
                                    <i class="fa fa-trash"></i> Deletar selecionados
                                </button>
                            </a>
                        @endshield
                        @shield('documents.create')
                            <a href="{!! route('documents.create') !!}">
                                <button type="button" class="btn btn-default">
                                    <i class="fa fa-plus-circle"></i> Novo registro
                                </button>
                            </a>
                        @endshield
                    </div>
                </div>
            </div>
        </div>
        <br>
        @include('flash::message')
        @if($documents->isEmpty())
            <div class="well text-center">Sem dados. Insira um novo registro.</div>
        @else
            @include('documents.table')
        @endif
    </div>
@endsection
