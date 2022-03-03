@extends('layouts.meeting')
@section('content-meeting')
    <div class="">
        <h2>ATA DA SESSÃO </h2>
        <div class="the-box rounded">
            <div class="col-md-6">
                <p><i class="fa fa-check-circle"></i> {!! $meeting->session_type->name !!}</p>
                <p><i class="fa fa-check-circle"></i> Sessão Nº: {!! $meeting->number !!}</p>
                <p><i class="fa fa-check-circle"></i> Data: {!! $meeting->date_start !!}</p>
            </div>
            <div class="col-md-6">
                <a href="/meeting/ata/{{ $meeting->id }}/pdf" target="_blank"><button class="pull-right btn btn-info btn-rounded-lg"><i class="fa fa-file-pdf-o"></i> Gerar PDF </button></a>
            </div>
            <div class="clearfix"></div>
            <form action="/meetings/ata" method="post">
                {!! Form::token() !!}
                <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                <textarea name="ata" id="ata" class="ckeditor">{{ $meeting->ata }}</textarea>
                <hr class="hr">
                <button class="btn btn-success pull-right"><i class="fa fa-save"></i> Salvar</button>
            </form>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-12 the-box rounded">
            <a href="/meetings"><button class="btn btn-default">Voltar</button></a>
        </div>
    </div>
@endsection
