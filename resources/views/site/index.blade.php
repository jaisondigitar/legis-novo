@extends('layouts.site')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    <style>
        .nav-tabs.centered > li, .nav-pills.centered > li {
            float:none;
            display:inline-block;
            *display:inline; /* ie7 fix */
            zoom:1; /* hasLayout ie7 trigger */
        }

        .nav-tabs.centered, .nav-pills.centered {
            text-align:center;
        }
        .activeClass{
            background: #353a4e;
            color: #FFFFFF;
        }

        .highlight {
            color: #ae501d;
            background-color: #ffe301
        }

    </style>

    <script src="/jquery.highlight-5.js"></script>


    <div id="h" style="height: auto;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 centered">
                    <a href="/">
                        <img
                            src="/assets/images/genesis-black.png"
                            alt="image"
                            style="max-width: 100%;
                            height: 50%;"
                        >
                    </a>
                    <div class="mtb">
                        <div>
                            <ul class="nav nav-tabs centered" role="tablist">
                                <li role="presentation" class="@if(isset($_GET['documents'])) in active @endif">
                                    <a href="#docs" aria-controls="docs" role="tab" data-toggle="tab">
                                        DOCUMENTOS
                                    </a>
                                </li>
                                <li role="presentation" class="@if(isset($_GET['projects'])) in active @endif">
                                    <a href="#projects" aria-controls="projects" role="tab" data-toggle="tab">
                                        PROJETOS DE LEI
                                    </a>
                                </li>
                                <li role="presentation" class="@if(isset($_GET['atas'])) in active @endif">
                                    <a href="#atas" aria-controls="atas" role="tab" data-toggle="tab">
                                        ATAS/PAUTAS
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div
                                role="tabpanel"
                                class="tab-pane fade @if(isset($_GET['documents'])) in active @endif"
                                id="docs"
                            >
                                <h1>DOCUMENTOS</h1>
                                <form method="GET" id="formDocuments">
                                    <input type="hidden" name="documents" value="true">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('owner_id', 'Tipo:') !!}
                                        {!! Form::select('type', $doctypes ,(($form->input('type')) !== null ? $form->input('type'): null), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-2">
                                        {!! Form::label('date', 'Número:') !!}
                                        {!! Form::text('number', (($form->input('number')) !== null ? $form->input('number'): null), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-2">
                                        {!! Form::label('date', 'Ano:') !!}
                                        {!! Form::text('year', (($form->input('year')) !== null ? $form->input('year'): null), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::label('owner_id', 'Responsável') !!}
                                        {!! Form::select('owner', $assemblymensList ,(($form->input('owner')) !== null ? $form->input('owner'): null), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-10">
                                        {!! Form::label('date', 'Que contenha (texto):') !!}
                                        {!! Form::text('text', (($form->input('text')) !== null ? $form->input('text'): null), ['id'=>'texto', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-2">
                                        {!! Form::label('frase', 'Frase completa:') !!}
                                        {!! Form::checkbox('frase', null, 0, ['class' => 'form-control ']) !!}
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-2">
                                        <button type="reset" class="btn btn-block btn-warning"><i class="fa fa-recycle"></i> Reset</button>
                                    </div>
                                    <div class="form-group col-md-10">
                                        <button class="btn btn-block btn-primary" onclick="find_word()"><i class="fa fa-search"></i> Pesquisar</button>
                                    </div>
                                </form>
                            </div>
                            <div
                                role="tabpanel"
                                class="tab-pane fade @if(isset($_GET['projects'])) in active @endif"
                                id="projects"
                            >
                                <h1>PROJETOS DE LEI</h1>
                                <form method="GET" id="formDocuments">
                                    <input type="hidden" name="projects" value="true">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('owner_id', 'Tipo:') !!}
                                        {!! Form::select('type', App\Models\LawsType::lists('name', 'id')->prepend('Selecione...', '') ,$form->input('type'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-2">
                                        {!! Form::label('date', 'Número:') !!}
                                        {!! Form::text('number', (($form->input('number')) !== null ? $form->input('number'): null), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-2">
                                        {!! Form::label('date', 'Ano:') !!}
                                        {!! Form::text('year', (($form->input('year')) !== null ? $form->input('year'): null), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::label('owner_id', 'Responsável') !!}
                                        {!! Form::select('owner', $assemblymensList ,(($form->input('owner')) !== null ? $form->input('owner'): null), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-10">
                                        {!! Form::label('date', 'Que contenha (texto):') !!}
                                        {!! Form::text('text', (($form->input('text')) !== null ? $form->input('text'): null), ['id'=>'texto', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-2">
                                        {!! Form::label('frase', 'Frase completa:') !!}
                                        {!! Form::checkbox('frase', null, 0, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-2">
                                        <button type="reset" class="btn btn-block btn-warning"><i class="fa fa-recycle"></i> Reset</button>
                                    </div>
                                    <div class="form-group col-md-10">
                                        <button class="btn btn-block btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                                    </div>
                                </form>
                            </div>
                            <div
                                role="tabpanel"
                                class="tab-pane fade @if(isset($_GET['atas'])) in active @endif"
                                id="atas"
                            >
                                <h1>ATAS E PAUTAS</h1>
                                <form method="GET" id="formDocuments">
                                    <input type="hidden" name="atas" value="true">
                                    <div class="form-group col-md-offset-4 col-md-3">
                                        {!! Form::label('type', 'Tipo:') !!}
                                        {!! Form::select('type', App\Models\SessionType::lists('name', 'id')->prepend('Selecione...', '') ,$form->input('type'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-2">
                                        {!! Form::label('date', 'Data:') !!}
                                        {!! Form::text('data', (($form->input('data')) !== null ? $form->input('data'): null), ['class' => 'form-control datepicker']) !!}
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-2">
                                        <button type="reset" class="btn btn-block btn-warning"><i class="fa fa-recycle"></i> Reset</button>
                                    </div>
                                    <div class="form-group col-md-10">
                                        <button class="btn btn-block btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div><!--/mt-->
                </div>
            </div><!--/row-->
        </div><!--/container-->
    </div><!-- /H -->

        @if(isset($_GET['documents']))
            <div class="container ptb">
                <div class="row">
                    <h1 style="margin-top: 0px">Registros</h1>
                    <div class="col-md-12">
                        <table class="table table-responsive" id="documentModels-table">
                            <thead>
                            <th>Data</th>
                            <th>Descrição</th>
                            {{--<th>Lido</th>--}}
                            {{--<th>Aprovado</th>--}}
                            <th colspan="3">Visualizar</th>
                            </thead>
                            <tbody>
                            @foreach($documents as $documentModel)
                                <tr class="line">
                                    <td>{!! $documentModel->date !!}</td>
                                    <td>
                                        <strong style="text-transform: uppercase;">
                                            {!! $documentModel->document_type->name !!}
                                            {!! $documentModel->number . '/' . $documentModel->getYear($documentModel->date) !!} -
                                            {!! $documentModel->owner->short_name !!}
                                        </strong><br>
                                        @if(strlen($documentModel->content)>=600)
                                            {!! substr(strip_tags($documentModel->content), 0, strrpos(substr(strip_tags($documentModel->content), 0, 600), ' ')) . '...'; !!}
                                        @else
                                            {{ strip_tags($documentModel->content) }}
                                        @endif
                                        <br>
                                        @if($download->value && count($documentModel->documents)>0)
                                            <br>
                                            <div>
                                                <strong>Anexos: </strong>
                                                <div class="clearfix"></div>
                                                @foreach($documentModel->documents as $doc)
                                                    @if(file_exists('uploads/documents/files/' . $doc->filename))
                                                    <div class="col-md-3" style="width: auto !important;">
                                                    <a
                                                        href="{{('uploads/documents/files') . '/' . $doc->filename}}"
                                                        target="_blank"
                                                        class="btn btn-xs btn-success"
                                                    >
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ url('download-document/'. $doc->filename) }}">
                                                        <button class="btn btn-xs btn-info">
                                                            {{ $doc->filename }}
                                                        </button>
                                                    </a>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class='btn-group'>
                                            <a
                                                target="_blank"
                                                href="{!! url('documentPdf', [$documentModel->id]) !!}"
                                                class='btn btn-default btn-xs'
                                            >
                                                PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--/row-->
                {!! $documents->appends(request()->input())->render() !!}
            </div><!--/container-->
        @elseif(isset($_GET['projects']))
            <div class="container ptb">
                <div class="row">
                    <h1 style="margin-top: 0px">Registros</h1>
                    <div class="col-md-12">
                        <table class="table table-responsive" id="documentModels-table">
                            <thead>
                                <th>Descrição</th>
                                <th>Download</th>
                            </thead>
                            <tbody>
                                @foreach($documents as $lawsProject)
                                    <tr class="line">
                                        <td>
                                            <strong>
                                                {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!} -
                                                @if(!$lawsProject->law_type)
                                                    {{ $lawsProject->law_type_id }}
                                                @else {{ mb_strtoupper($lawsProject->law_type->name, 'UTF-8') }}
                                                @endif
                                            </strong><br>
                                            {!! $lawsProject->title !!}
                                        </td>
                                        <td>
                                            @if($lawsProject->lawFiles || $lawsProject->file)
                                                <button
                                                    type="button"
                                                    class="btn btn-info btn-xs"
                                                    data-toggle="modal"
                                                    data-target="#anexos_{{$lawsProject->id}}"
                                                >
                                                    <i class="fa fa-paperclip"></i> Anexos
                                                </button>
                                            @endif

                                            <a
                                                target="_blank"
                                                href="{!! url('lawPdf', [$lawsProject->id]) !!}"
                                                class='btn btn-default btn-xs'
                                            >
                                                PROJETO
                                            </a>

                                            @if($lawsProject->is_ready == 1)
                                                <label class="label label-success">SANCIONADA</label>
                                            @endif
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="anexos_{{$lawsProject->id}}" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h3 class="modal-title">Anexos</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <h4> Clique no link para download</h4>
                                                    <ul class="list-group">
                                                        @foreach($lawsProject->advices()->where('laws_projects_id', $lawsProject->id)->get() as $advices)
                                                            @foreach($advices->awnser()->get() as $awnser)
                                                                @if($awnser->file != '')
                                                                    <li class="list-group-item">
                                                                        <a
                                                                            href="/uploads/advice_awnser/{{$awnser->file}}"
                                                                            target="_blank"
                                                                        >
                                                                            {{$awnser->file}} - <i class="fa fa-download"></i>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        @foreach($lawsProject->lawFiles as $file)
                                                            <li class="list-group-item">
                                                                <a
                                                                    href="{{ url('download-law/' .$file->filename. '/id/' . $file->law_project_id ) }}"
                                                                    target="_blank"
                                                                >
                                                                     {{$file->filename}} - <i class="fa fa-download"></i>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--/row-->
                {!! $documents->appends(request()->input())->render() !!}
            </div><!--/container-->
        @elseif(isset($_GET['atas']))
            <div class="container ptb">
                <div class="row">
                    <h1 style="margin-top: 0px">Registros</h1>
                    <div class="col-md-12">
                        <table class="table table-responsive" id="documentModels-table">
                            <thead>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Numero</th>
                                <th>Local</th>
                                <th colspan="3">Visualizar</th>
                            </thead>
                            <tbody>
                            @foreach($documents as $meeting)
                                <tr>
                                    <td>{!! $meeting->date_start !!}</td>
                                    <td>{!! $meeting->session_type->name !!}</td>
                                    <td>{!! $meeting->number !!}</td>
                                    <td>{!! $meeting->session_place->name !!}</td>
                                    <td>
                                        <div class='btn-group'>
                                            @if($meeting->files()->count()>0)
                                                <button
                                                    type="button"
                                                    class="btn btn-success btn-xs"
                                                    data-toggle="modal"
                                                    data-target="#anexos_ata_{{$meeting->id}}"
                                                    style="margin-right: 2px;"
                                                >
                                                    <i class="fa fa-paperclip"></i> Anexos
                                                </button>
                                            @endif
                                            @if($params['showPautas'])
                                                <a
                                                    target="_blank"
                                                    href="/meeting/pauta/{{ $meeting->id }}/pdf"
                                                    class='btn btn-primary btn-xs'
                                                >
                                                    <i class="fa fa-download"></i> PAUTA
                                                </a>
                                            @endif
                                            @if($params['showAtas'])
                                                <a
                                                    target="_blank"
                                                    href="/meeting/ata/{{ $meeting->id }}/pdf"
                                                    class='btn btn-warning btn-xs'
                                                >
                                                    <i class="fa fa-download"></i> ATA
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="anexos_ata_{{$meeting->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h3 class="modal-title">Anexos</h3>
                                            </div>
                                            <div class="modal-body">
                                                <h4> Clique no link para download</h4>
                                                <ul class="list-group">
                                                    @foreach($meeting->files()->where('meeting_id', $meeting->id)->get() as $files)
                                                        @if($files->filename != '')
                                                            <li class="list-group-item">
                                                                <a
                                                                    href="/uploads/meetings/files/{{$files->filename}}"
                                                                    target="_blank"
                                                                >
                                                                    {{$files->filename}} - <i class="fa fa-download"></i>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--/row-->
                {!! $documents->appends(request()->input())->render() !!}
            </div><!--/container-->
        @endif

    <script>
        $(document).ready(function () {

            getMeetingDates();

            const palavra = $('#texto').val().split(" ");

            $.each(palavra, function(j,palavra){
                $('.line').highlight(palavra);
            });
        });

        const loadPicker = function(dates)
        {
            $('.datepicker').datepicker({
                language: 'pt-BR',
                format: 'dd/mm/yyyy',
                autoclose: true,
                beforeShowDay: function(date) {
                    const active_dates = dates;
                    const d = date;
                    const curr_date = d.getDate();
                    const curr_month = d.getMonth() + 1; //Months are zero based
                    const curr_year = d.getFullYear();
                    const formattedDate = curr_date + "/" + curr_month + "/" + curr_year

                    if ($.inArray(formattedDate, active_dates) !== -1){
                        return {
                            classes: 'activeClass'
                        };
                    }else{
                        return {
                            enabled: false
                        }
                    }
                }
            });
        };

        const getMeetingDates = function()
        {
            $.ajax({
                url: '/getMeetingDates'
            }).success(function (data) {

                datas = JSON.parse(data);

                $.each(datas,function(index, value){
                    datas[index] = value.replace('-','/').replace('-','/');
                });

                loadPicker(datas);
            });
        }
    </script>
@endsection
