@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('commissions.list') !!}
@endsection
@section('content')

    <link href="/assets/css/jquery-loading.css" rel="stylesheet">
    <style media="screen">
        .js-loading-overlay {
            background-color: rgba(0,0,0,.7);
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .button-doc:hover{
            background-color: #009bbd;
            color:white;
        }

        .button-law:hover{
            background-color: #c54c50;
            color:white;
        }

        .button-doc{
            margin-top: 15px;
            background-color: #005F73;
            color: white;
            border-radius: 10px;
            border: 1px solid #005F73;
        }
        .button-law{
            margin-top: 20px;
            background-color: #9B2226;
            color: white;
            border-radius: 10px;
            border: 1px solid #9B2226;
        }

        #margem-buttons{
            margin: 0 0 0 45rem;
        }
    </style>
    <div id="spin2"></div>
    <div style="margin: 1rem 3.125rem 1rem 3.125rem" class="the-box rounded">
    <div class="row">
        <div class="col-md-6">
            <h2>Exportador</h2>
            <h4 class="text-muted"> Total de Registros : {{count(\App\Models\Job::all())}}</h4>
        </div>
        {{--<div class="col-md-6">--}}
            {{--<span class="pull-right" style="margin-top: 40px;">--}}
                {{--<a href="/config/export/files/documents" class="btn btn-primary"> Documentos </a>--}}
                {{--<button type="button" class="btn btn-info"> Projeto de lei </button>--}}
            {{--</span>--}}
        {{--</div>--}}
        <div class="clearfix"></div>
        <hr>

        <div class="col-md-2" id="margem-buttons">
            <div class="panel text-center">
                <div class="panel-heading" >
                    <h3 class="panel-title text-uppercase">Gerar PDF</h3>
                </div>
                <div class="panel-body" style="height: 166px;">
                    <a href="/config/export/files/documents" class="btn btn-default btn-lg button-doc" > DOCUMENTOS </a>
                    <div class="clearfix"></div>
                    <a href="/config/export/files/laws" class="btn btn-default btn-lg button-law" > PROJETO DE LEI </a>
                </div>
            </div>
        </div>

            <div  class="panel panel-info panel-square ">
                    <div class="panel-heading" >
                        <h3 style="text-align: center" class="panel-title">Links para download</h3>
                    </div>
                <div class="panel-body text-center">
                    <p>
                        <h4>
                            Quando o backup estiver pronto os links para download estarão abaixo
                        </h4>
                    </p>
                    <HR>
                    {{--<a href="/config/export/files/zip" class="btn btn-primary btn-lg text-center"> DOCUMENTOS <i class="fa fa-paperclip"></i> </a>--}}
                    {{--<a href="/config/export/files/laws/zip" class="btn btn-primary btn-lg"> PROJETO DE LEI <i class="fa fa-paperclip"></i> </a>--}}
                    {{--<a href="/config/export/files/zip" class="btn btn-primary btn-lg"> GERAR ZIP <i class="fa fa-paperclip"></i> </a>--}}

                    <div class="col-md-12">
                        @if(file_exists(public_path('exportacao/documentos-compactados.zip')))
                            DOCUMENTOS : <a href="/exportacao/documentos-compactados.zip"> {{url('exportacao/documentos-compactados.zip')}} </a>
                        @endif
                        <br>
                        @if(file_exists(public_path('exportacao/projetoLei-compactados.zip')))
                            PROJETO DE LEI : <a href="/exportacao/projetoLei-compactados.zip"> {{url('exportacao/projetoLei-compactados.zip')}} </a>
                        @endif
                    </div>
                </div>
            </div>
        <div class="clearfix"></div>





@endsection
