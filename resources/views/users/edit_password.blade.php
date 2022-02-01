@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('users.list') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="row">
            <!--- Password Field --->
            {!! Form::open(['route' => 'password.update']) !!}
            <div class="form-group col-sm-4">
                {!! Form::label('old_password', 'Senha Antiga:') !!}
                {!! Form::password('old_password', ['class' => 'form-control']) !!}
            </div>

            <!--- Password Field --->
            <div class="form-group col-sm-4">
                {!! Form::label('new_password', 'Nova Senha:') !!}
                {!! Form::password('new_password', ['class' => 'form-control']) !!}
            </div>

            <!--- Password Field --->
            <div class="form-group col-sm-4">
                {!! Form::label('confirm_password', 'Confirmar Senha:') !!}
                {!! Form::password('confirm_password', ['class' => 'form-control']) !!}
            </div>

            <!--- Password Field --->
            <div class="form-group col-sm-12">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                <a href="/admin" class="btn btn-default">Cancelar</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
