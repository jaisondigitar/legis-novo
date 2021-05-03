@extends('layouts.meeting')
@section('content-meeting')
    <style>
        .document_list{
            margin-left: 5px;
            font-style: italic;
            text-align: justify;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="text-decoration: none; color:#fff;" >
                                RESUMO DA VOTAÇÃO
                                <span class="pull-right"> <i class="fa fa-arrow-down" onclick="icon_toogle(this)"></i> </span>
                            </a>

                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <ul class="list-group">
                                @forelse($meeting->voting()->where('version_pauta_id', $meeting->version_pauta_id)->get() as $voting)
                                    <li class="list-group-item text-uppercase">
                                        @if($voting->ata_id > 0)
                                            ATA Nº - {{$last_voting->number}}/{{Carbon\Carbon::createFromFormat('d/m/Y H:i',$last_voting->date_start)->year}}
                                        @else
                                            @if($voting->advice_id == 0)
                                            {{$voting->getName()}}
                                            @else
                                                {{$voting->advice->commission->name}} - {{$voting->getNameAdvice()}}
                                            @endif
                                        @endif

                                        @if($voting->situation($voting))
                                            <span class="pull-right text-primary" >
                                                Aprovada
                                            </span>
                                        @else
                                            @if(!isset($voitng->closed_at))
                                                <span class="pull-right text-danger"> Reprovada</span>
                                            @else
                                                <span class="pull-right text-warning"> Em votação</span>
                                            @endif
                                        @endif

                                    </li>
                                @empty
                                    <li class="list-group-item">
                                        Não existe votação encerrada
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <h2>VOTAÇÃO </h2>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-primary">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="text-decoration: none; color:#fff;" >
                                    ATA
                                    <span class="pull-right"> <i class="fa fa-arrow-up" onclick="icon_toogle(this)"></i> </span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                @if($meeting)
                                    <div class="row-fluid text-uppercase">
                                        <span>
                                            @if($last_voting != null)
                                                ATA Nº - {{$last_voting->number}}/{{Carbon\Carbon::createFromFormat('d/m/Y H:i',$last_voting->date_start)->year}}
                                                @if(isset($meeting->voting()->where('ata_id', $last_voting->id)->first()->closed_at))
                                                    <br>
                                                    <span class="document_list @if($meeting->situation($last_voting->id, 'ata')) text-primary @else text-danger @endif">
                                                    @if($meeting->situation($last_voting->id, 'ata'))
                                                            Votação aprovada
                                                        @else
                                                            Votação reprovada
                                                        @endif
                                                    </span>
                                                @endif
                                            @endif
                                        </span>
                                        <span class="pull-right">
                                            <span class="pull-right" @if(isset($meeting->voting()->where('meeting_id', $meeting->id)->whereNotNull('deleted_at')->first()->closed_at)) style="margin-top: 10px;" @endif>
                                                @if($ata_voting && ($last_voting != null))
                                                    @if(isset($meeting->voting()->where('ata_id', $last_voting->id)->first()->closed_at))
                                                        <a href="/resume/voting/{{$meeting->voting()->where('ata_id', $last_voting->id)->first()->id}}" target="_blank">
                                                            <button class="btn btn-info btn-xs">Resumo</button>
                                                        </a>
                                                        <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/ata/{{$last_voting->id}}">
                                                            <button class="btn btn-danger btn-xs">Encerrada</button>
                                                        </a>
                                                    @else
                                                        @if(($meeting->voting()->where('ata_id', $last_voting->id)->first()))
                                                            <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/ata/{{$last_voting->id}}">
                                                                <button class="btn btn-warning btn-xs">Em andamento</button>
                                                            </a>
                                                        @else
                                                            <button class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#primaryModalColor2" onclick="voting_ata({{$last_voting}})">Abrir Votação</button>
                                                        @endif
                                                    @endif
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                @else
                                    Sessão anterior não possui ATA
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-primary">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree" style="text-decoration: none; color:#fff;" >
                                    PARECER
                                    <span class="pull-right"> <i class="fa fa-arrow-up" onclick="icon_toogle(this)"></i> </span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                <ul class="list-group">
                                    @foreach($advices as $item)
                                        <li class="list-group-item">
                                            <div class="col-lg-10 text-uppercase">
                                                {!! $item->commission->name . ' - ' !!}
                                                @if($item->document_id > 0)
                                                    @if($item->document->document_type->parent_id) {{ $item->document->document_type->parent->name }} ::  @endif {!! $item->document->document_type->name !!} -
                                                    @if($item->document->number == 0)
                                                    @else
                                                        {!! $item->document->number . '/' . $item->document->getYear($item->date) !!}
                                                    @endif
                                                    <br>
                                                    @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at))
                                                        <span class="document_list @if($meeting->situation($item->id, 'advice')) text-primary @else text-danger @endif">
                                                            @if($meeting->situation($item->id, 'advice'))
                                                                Votação aprovada
                                                            @else
                                                                Votação reprovada
                                                            @endif
                                                        </span>
                                                    @endif
                                                @endif

                                                @if($item->laws_projects_id > 0)
                                                    @if(!$item->project->law_type) {{ $item->project->law_type_id }} @else {!! mb_strtoupper($item->project->law_type->name, 'UTF-8') !!} @endif

                                                    <span id="tdLawProjectNumber">
                                                        {!! $item->project->project_number . '/' . $item->project->getYearLawPublish($item->project->law_date) !!}
                                                    </span>
                                                    <br>
                                                    @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at))
                                                        <span class="document_list @if($meeting->situation($item->id, 'advice')) text-primary @else text-danger @endif">
                                                        @if($meeting->situation($item->id, 'advice'))
                                                            Votação aprovada
                                                        @else
                                                            Votação reprovada
                                                        @endif
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-lg-2">
                                                <span class="pull-right" @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at)) style="margin-top: 10px;" @endif>
                                                    @if($advice_voting)
                                                        @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at))
                                                            @if($item->document_id > 0)
                                                                <a href="/resume/voting/{{$item->voting()->where('meeting_id', $meeting->id)->first()->id}}" target="_blank">
                                                                <button class="btn btn-info btn-xs">Resumo</button>
                                                             </a>
                                                                <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/advice/{{$item->id}}"> <button class="btn btn-danger btn-xs">Encerrada</button></a>
                                                            @endif

                                                            @if($item->laws_projects_id > 0)
                                                                <a href="/resume/voting/{{$item->voting()->where('meeting_id', $meeting->id)->first()->id}}" target="_blank">
                                                                <button class="btn btn-info btn-xs">Resumo</button>
                                                                </a>
                                                                <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/advice/{{$item->id}}"> <button class="btn btn-danger btn-xs">Encerrada</button></a>
                                                            @endif
                                                        @else
                                                            @if(!$item->voting()->where('meeting_id', $meeting->id)->first())
                                                                <button class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#primaryModalColor3" onclick="voting_advice({{$item}})">Abrir Votação</button>
                                                            @else
                                                                <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/advice/{{$item->id}}"> <button class="btn btn-warning btn-xs">Em andamento</button></a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-info">
                        <div class="panel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour" style="text-decoration: none; color:#fff;" >
                                    DOCUMENTOS
                                    <span class="pull-right"> <i class="fa fa-arrow-up" onclick="icon_toogle(this)"></i> </span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
                            <div class="panel-body">
                                <ul class="list-group">
                                    @foreach($docs as $item)
                                        <li class="list-group-item">
                                            <div class="col-lg-10 text-uppercase">
                                                <span class="text-uppercase">
                                                Documento :
                                                </span>
                                                @if($item->document_type->parent_id) {{ $item->document_type->parent->name }} ::  @endif {!! $item->document_type->name !!} -
                                                @if($item->number==0)
                                                @else
                                                    {!! $item->number . '/' . $item->getYear($item->date) !!}
                                                @endif
                                                <br>
                                                @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at))
                                                    <span class="document_list @if($meeting->situation($item->id, 'document')) text-primary @else text-danger @endif">
                                                        @if($meeting->situation($item->id, 'document'))
                                                                Votação aprovada
                                                            @else
                                                                Votação reprovada
                                                            @endif
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-lg-2">
                                                <span class="pull-right" @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at)) style="margin-top: 10px;" @endif>
                                                    @if($doc_voting)
                                                        @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at))
                                                            <a href="/resume/voting/{{$item->voting()->where('meeting_id', $meeting->id)->first()->id}}" target="_blank">
                                                                <button class="btn btn-info btn-xs">Resumo</button>
                                                             </a>
                                                            <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/document/{{$item->id}}"> <button class="btn btn-danger btn-xs">Encerrada</button></a>
                                                        @else
                                                            @if(!$item->voting()->where('meeting_id', $meeting->id)->first())
                                                                <button class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#InfoModalColor2" onclick="voting_document({{$item}})">Abrir Votação</button>
                                                            @else
                                                                <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/document/{{$item->id}}"> <button class="btn btn-warning btn-xs">Em andamento</button></a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div><!-- /.panel-body -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-warning">
                        <div class="panel-heading" role="tab" id="headingFive">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive" style="text-decoration: none; color:#fff;" >
                                    PROJETO DE LEI
                                    <span class="pull-right"> <i class="fa fa-arrow-up" onclick="icon_toogle(this)"></i> </span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
                            <div class="panel-body">
                                <ul class="list-group">
                                    @foreach($laws  as $item)
                                        <li class="list-group-item">
                                            <div class="col-lg-10 text-uppercase">
                                                Projeto de lei :

                                                @if(!$item->law_type) {{ $item->law_type_id }} @else {!! mb_strtoupper($item->law_type->name, 'UTF-8') !!} @endif

                                                <span id="tdLawProjectNumber">
                                                    {!! $item->project_number . '/' . $item->getYearLawPublish($item->law_date) !!}
                                                </span>

                                                <br>
                                                @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at))
                                                    <span class="document_list @if($meeting->situation($item->id, 'law')) text-primary @else text-danger @endif">
                                                        @if($meeting->situation($item->id, 'law'))
                                                                Votação aprovada
                                                            @else
                                                                Votação reprovada
                                                            @endif
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-lg-2">
                                                <span class="pull-right" @if(isset($item->voting->closed_at)) style="margin-top: 30px;" @else style="margin-top: 10px;" @endif>
                                                    @if($law_voting)
                                                        @if(isset($item->voting()->where('meeting_id', $meeting->id)->first()->closed_at))
                                                            <a href="/resume/voting/{{$item->voting()->where('meeting_id', $meeting->id)->first()->id}}" target="_blank">
                                                                <button class="btn btn-info btn-xs">Resumo</button>
                                                             </a>
                                                            <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/law/{{$item->id}}"> <button class="btn btn-danger btn-xs">Encerrada</button></a>
                                                        @else
                                                            @if(!$item->voting()->where('meeting_id', $meeting->id)->first())
                                                                <button type="button" class="btn btn-primary btn-block btn-xs" data-toggle="modal" data-target="#WarningModalColor2" onclick="voting_law({{$item}})">Abrir Votação</button>
                                                            @else
                                                                <a href="/meetings/{{$meeting->id}}/voting/{{$meeting->voting->id}}/law/{{$item->id}}"> <button class="btn btn-warning btn-xs">Em andamento</button></a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div><!-- /.panel-body -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="WarningModalColor2" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content modal-no-shadow modal-no-border">
                <div class="modal-header bg-warning no-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase">votação do projeto de lei</h4>
                </div>
                <form action="/meetings/{{$meeting->id}}/voting/create" id="form_document" method="POST">
                    {!!  Form::token() !!}
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="hidden" id="meeting_id" name="meeting_id" value="{{$meeting->id}}" >
                            <input type="hidden" id="law_id" name="law_id" value="0" >
                            <div class="form-group ">
                                <label> Sessão </label>
                                <input type="text" id="meeting_name"  name="meeting_name" value="{{$meeting->number}}/{{Carbon\Carbon::createFromFormat('d/m/Y H:i',$meeting->date_start)->year}}" class="form-control" placeholder="Enter email" disabled>
                            </div>
                            <div class="form-group">
                                <label> Projeto de Lei </label>
                                <input type="text" id="law_name" name="law_name" value="" class="form-control" placeholder="Password" disabled>
                            </div>
                            <div class="form-group" hidden>
                                <label> Tipo de votação </label>
                                {!! Form::select('type_voting_id', $type_voting, null, ['id'=> 'type_voting_id', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info">Abrir</button>
                    </div><!-- /.modal-footer -->
                </form>
            </div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .warning .full -->
        </div><!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="InfoModalColor2" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content modal-no-shadow modal-no-border">
                <div class="modal-header bg-info no-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase">Votação do documento</h4>
                </div>

                <form action="/meetings/{{$meeting->id}}/voting/create" id="form_law" method="POST">
                    {!!  Form::token() !!}
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="hidden" id="meeting_id" name="meeting_id" value="{{$meeting->id}}"  >
                            <input type="hidden" id="document_id" name="document_id" value="0" >
                            <div class="form-group ">
                                <label> Sessão </label>
                                <input type="text" id="meeting_name"  name="meeting_name" value="{{$meeting->number}}/{{Carbon\Carbon::createFromFormat('d/m/Y H:i',$meeting->date_start)->year}}" class="form-control" placeholder="Enter email" disabled>
                            </div>
                            <div class="form-group">
                                <label> Documento </label>
                                <input type="text" id="document_name" name="document_name" value="" class="form-control" placeholder="Password" disabled>
                            </div>
                            <div class="form-group" hidden>
                                <label> Tipo de votação </label>
                                {!! Form::select('type_voting_id', $type_voting, null, ['id'=> 'type_voting_id', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info">Abrir</button>
                    </div><!-- /.modal-footer -->
                </form>
            </div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->
        </div><!-- /.modal-dialog -->
    </div>

    @if($last_voting != null)
    <div class="modal fade" id="primaryModalColor2" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content modal-no-shadow modal-no-border">
                <div class="modal-header bg-info no-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase">Votação da ata</h4>
                </div>

                <form action="/meetings/{{$meeting->id}}/voting/create" id="form_ata" method="POST">
                    {!!  Form::token() !!}
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="hidden" id="meeting_id" name="meeting_id" value="{{$meeting->id}}"  >
                            <input type="hidden" id="ata_id" name="ata_id" value="{{$last_voting->id}}" >
                            <div class="form-group ">
                                <label> Sessão </label>
                                <input type="text" id="meeting_name"  name="meeting_name" value="{{$meeting->number}}/{{Carbon\Carbon::createFromFormat('d/m/Y H:i',$meeting->date_start)->year}}" class="form-control" placeholder="Enter email" disabled>
                            </div>
                            <div class="form-group">
                                <label> ATA </label>
                                <input type="text" id="ata_name" name="ata_name" value="{{$last_voting->number}}/{{Carbon\Carbon::createFromFormat('d/m/Y H:i',$last_voting->date_start)->year}}" class="form-control" placeholder="Password" disabled>
                            </div>
                            <div class="form-group" hidden>
                                <label> Tipo de votação </label>
                                {!! Form::select('type_voting_id', $type_voting, null, ['id'=> 'type_voting_id', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info">Abrir</button>
                    </div><!-- /.modal-footer -->
                </form>
            </div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->
        </div><!-- /.modal-dialog -->
    </div>
    @endif


    <div class="modal fade" id="primaryModalColor3" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content modal-no-shadow modal-no-border">
                <div class="modal-header bg-info no-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase">
                        Votação de parecer
                    </h4>
                    <span id="commission_name">

                    </span>
                </div>

                <form action="/meetings/{{$meeting->id}}/voting/create" id="form_ata" method="POST">
                    {!!  Form::token() !!}
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="hidden" id="meeting_id" name="meeting_id" value="{{$meeting->id}}"  >
                            <input type="hidden" id="advice_id" name="advice_id" value="0" >
                            <div class="form-group ">
                                <label> Sessão </label>
                                <input type="text" id="meeting_name"  name="meeting_name" value="{{$meeting->number}}/{{Carbon\Carbon::createFromFormat('d/m/Y H:i',$meeting->date_start)->year}}" class="form-control" placeholder="Enter email" disabled>
                            </div>
                            <div class="form-group">
                                <label> Parecer </label>
                                <input type="text" id="advice_name" name="advice_name" value="0" class="form-control text-uppercase" placeholder="Password" disabled>
                            </div>
                            <div class="form-group" hidden>
                                <label> Tipo de votação </label>
                                {!! Form::select('type_voting_id', $type_voting, null, ['id'=> 'type_voting_id', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info">Abrir</button>
                    </div><!-- /.modal-footer -->
                </form>
            </div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->
        </div><!-- /.modal-dialog -->
    </div>


    <script>

        var icon_toogle = function (icon) {
            if($(icon).attr('class') == 'fa fa-arrow-down'){
                $(icon).removeClass('fa fa-arrow-down');
                $(icon).addClass('fa fa-arrow-up');
            }else{
                $(icon).removeClass('fa fa-arrow-up');
                $(icon).addClass('fa fa-arrow-down');
            }

        }


        var voting_document = function (doc) {

            var doc_id = $('#document_id').val(doc.id);

            var name="";

            if(doc.document_type.parent_id){ name = doc.document_type.parent.name + '::'; } name = name + doc.document_type.name + ' - ' ;

            if(doc.number==0) {
            } else {
                name = name + doc.number + '/' +  new Date(doc.date).getFullYear();
            }

            var meeting_id = $('#document_name').val(name);
        }

        var voting_law = function (law)
        {
            var law_id = $('#law_id').val(law.id);
            var meeting_id = $('#meeting_id').val('{{$meeting->id}}');

            var name="";

            if(!law.law_type){ name = law.law_type_id + ' : ' } else { name = law.law_type.name.toUpperCase() + ' : '; }

            var year = law.law_date.split('/');

            name = name + law.project_number + '/' + year[2];

            var meeting_id = $('#law_name').val(name);
        }

        var voting_advice = function (advice)
        {
            console.log(advice);

            var advice_id = $('#advice_id').val(advice.id);
            var meeting_id = $('#meeting_id').val('{{$meeting->id}}');

            var name="";
            $('#commission_name').text(advice.commission.name);
            if(advice.document_id > 0){
                if(advice.document.document_type.parent_id){ name = advice.document.document_type.parent.name + '::'; } name = name + advice.document.document_type.name + ' - ' ;

                if(advice.document.number==0) {
                } else {
                    data = advice.document.date.split('/');
                    name = 'DOCUMENTO : ' + name + advice.document.number + '/' +  data[2];
                }

                var meeting_id = $('#advice_name').val(name);
            }

            if(advice.laws_projects_id > 0){

                data = advice.project.law_date.split('/');

                name = ' PROJETO DE LEI : ' + advice.project.law_type.name + ' - ' + advice.project.project_number + '/' + data[2];
                var meeting_id = $('#advice_name').val(name);
            }

            // if(!law.law_type){ name = law.law_type_id + ' : ' } else { name = law.law_type.name.toUpperCase() + ' : '; }
            //
            // var year = law.law_date.split('/');
            //
            // name = name + law.project_number + '/' + year[2];
            //
            // var meeting_id = $('#advice_name').val(name);
        }


    </script>

@endsection

