@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <form method="GET">
            <div class="form-group col-md-2">
                {!! Form::label('date', 'Registro:') !!}
                {!!
                    Form::text('created_at', $form->input('updated_at'), [
                        'class' => 'form-control datepicker text-center',
                        'minlength' => '10',
                        'maxlength' => '10',
                    ])
                !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('owner_id', 'Tipo:') !!}
                {!! Form::select(
                    'law_type_id',
                    App\Models\LawsType::where('is_active', true)
                        ->pluck('name', 'id')
                        ->prepend('Selecione...', ''),
                    $form->input('law_type_id'), ['class' => 'form-control'])
                !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('date', 'Número:') !!}
                {!! Form::input(
                    'number',
                    'project_number',
                    $form->input('project_number'),
                    ['class' => 'form-control', 'min' => 0])
                !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('date', 'Ano:') !!}
                {!! Form::input(
                    'number',
                    'law_date',
                    $form->input('law_date'),
                    ['class' => 'form-control', 'min' => 1000, 'max' => 9999])
                !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('owner_id', 'Responsável:') !!}
                {!! Form::select(
                    'assemblyman_id',
                    $assemblymensList,
                    $form->input('assemblyman_id'),
                    ['class' => 'form-control'])
                !!}
            </div>

            <div class="clearfix"></div>

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
                        @shield('documents.delete')
                            <a href="javascript:void(0)" onclick="deletaBash()" style="display: none;" class="deleteAll">
                                <button type="button" class="btn btn-danger">
                                    <i class="fa fa-trash"></i> DELETAR SELECIONADOS
                                </button>
                            </a>
                        @endshield
                        @shield('lawsProjects.create')
                            <a href="{!! route('lawsProjects.create') !!}">
                                <button type="button" class="btn btn-info">
                                    <i class="fa fa-plus-circle"></i> Novo registro
                                </button>
                            </a>
                        @endshield
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                @if($lawsProjects->isEmpty())
                    <div class="well text-center">Sem dados. Insira um novo registro.</div>
                @else
                    @include('lawsProjects.table')
                @endif
            </div>
        </div>
    </div>
@endsection
