@extends('errors/error')

@section('code', '422')
@section('title', __('Too Many Requests'))

@section('name', 'Entidade não processável')

@section('message', __('O cliente não deve repetir esta requisição sem modificações.'))
