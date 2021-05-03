@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <form method="GET">
            <div class="form-group col-md-2">
                {!! Form::label('date', 'Registro:') !!}
                {!! Form::text('reg', $form->input('reg'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('owner_id', 'Tipo:') !!}
                {!! Form::select('type', App\Models\LawsType::where('is_active', true)->lists('name', 'id')->prepend('Selecione...', '') ,$form->input('type'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('date', 'Número:') !!}
                {!! Form::text('number', $form->input('number'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('date', 'Ano:') !!}
                {!! Form::text('year', $form->input('year'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('owner_id', 'Responsável') !!}
                {!! Form::select('owner', $assemblymensList ,$form->input('owner'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('parecer', 'Parecer:') !!}
                {!! Form::select('parecer', [0=>'Todos', 1=>'Apenas com parecer'] ,$form->input('parecer'), ['class' => 'form-control']) !!}
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
                            <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> DELETAR SELECIONADOS</button>
                        </a>
                        @endshield
                        @shield('lawsProjects.create')<a href="{!! route('lawsProjects.create') !!}">
                            <button type="button" class="btn btn-info"><i class="fa fa-plus-circle"></i> Novo registro</button>
                        </a>@endshield
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                @include('lawsProjects.table')
            </div>
        </div>
        
    </div>
@endsection