@extends('layouts.meeting')
@section('content-meeting')
    <div class="col-lg-3" >
    <!-- BEGIN TODAY VISITOR TILES -->
        <div class="panel panel-primary panel-square panel-no-border text-center" style="border: 1px solid #49BD9A;">
            <div class="panel-heading">
                <h3 class="panel-title">PAINÉIS DIGITAIS</h3>
            </div>
            <div class="panel-body">
                <br>
                <a href="/painel-votacao/default"    target="_blank" class="text-uppercase"> Painel padrão </a> <br>
                <a href="/painel-votacao/voting"     target="_blank" class="text-uppercase"> Painel votação </a> <br>
                <a href="/painel-votacao/resume"     target="_blank" class="text-uppercase"> Painel resumo da votação </a> <br>
                <a href="/painel-votacao/discourse"  target="_blank" class="text-uppercase"> Painel discurso </a> <br>
                <br>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-success panel-block-color -->
    <!-- END TODAY VISITOR TILES -->
    </div>

    <div class="col-lg-3">
        <!-- BEGIN TODAY VISITOR TILES -->
        <div class="panel panel-warning panel-square panel-no-border text-center" style="border: 1px solid #F5B23A;">
            <div class="panel-heading">
                <h3 class="panel-title">DOCUMENTOS</h3>
            </div>
            <div class="panel-body">
                <br>
                <h1 class="bolded tiles-number text-warning">{{$meeting->meeting_pauta()->where('document_id', '!=', 'null')->count()}}</h1>
                <br>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-success panel-block-color -->
        <!-- END TODAY VISITOR TILES -->
    </div>

    <div class="col-lg-3">
        <!-- BEGIN TODAY VISITOR TILES -->
        <div class="panel panel-danger panel-square panel-no-border text-center" style="border: 1px solid #E64C37;">
            <div class="panel-heading">
                <h3 class="panel-title">PROJETO DE LEI</h3>
            </div>
            <div class="panel-body">
                <br>
                <h1 class="bolded tiles-number text-warning">{{$meeting->meeting_pauta()->where('law_id', '!=', 'null')->count()}}</h1>
                <br>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-success panel-block-color -->
        <!-- END TODAY VISITOR TILES -->
    </div>

    <div class="col-lg-3" >
        <!-- BEGIN TODAY VISITOR TILES -->
        <div class="panel panel-info panel-square panel-no-border text-center" style="border: 1px solid #33A6D5;">
            <div class="panel-heading">
                <h3 class="panel-title">PRESENÇA</h3>
            </div>
            <div class="panel-body">
                <p class="text-muted"><small>TOTAL DE VEREADORES - <strong>{{$assemblyman->count()}}</strong></small></p>
                <p class="text-muted"><small> PRESENTE -  <strong>{{$meeting->assemblyman()->count()}}</strong></small></p>
                <p class="text-muted"><small>AUSENTES <strong>{{$assemblyman->count() - $meeting->assemblyman()->count()}}</strong></small></p>
                <a target="_blank" href="{{route('meetings.presencePDF', $meeting->id )}}" class="btn btn-success btn-block"> Gerar PDF</a>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-success panel-block-color -->
        <!-- END TODAY VISITOR TILES -->
    </div>

@endsection
