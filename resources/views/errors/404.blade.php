@extends('errors/error')

@section('code', '404')
@section('title', __('Page Not Found'))

@section('name', 'Página não encontrada')

@section('image')
    <div class="body-image">
        <img alt="error" src="/svg/error.png" class="image">
    </div>
@endsection

@section('message', __('Desculpe, a página que procura não pode ser encontrada.'))
