@extends('errors/error')

@section('code', '503')
@section('title', __('Service Unavailable'))

@section('name', 'Serviço Indisponível')

@section('message', __($exception->getMessage() ?: 'O servidor está temporariamente indisponível.'))
