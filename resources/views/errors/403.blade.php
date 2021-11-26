@extends('errors/error')

@section('code', '403')
@section('title', __('Forbidden'))

@section('name', 'Proibido')

@section('message', __($exception->getMessage() ?: 'Desculpe, está proibido de aceder a esta página.'))
