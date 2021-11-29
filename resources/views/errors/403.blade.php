@extends('errors/error')

@section('code', '403')
@section('title', __('Forbidden'))

@section('name', 'Acesso Negado')

@section('message', __($exception->getMessage() ?: 'Página não altorizada.'))
