@extends('errors/error')

@section('code', '429')
@section('title', __('Too Many Requests'))

@section('name', 'Excesso de Requisições')

@section('message', __('Excesso de requisições feitas em um período muito curto de tempo, tente novamente mais tarde.'))
