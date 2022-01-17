<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title text-uppercase" style="font-size: 15px;">
            <label>
                <input type="checkbox" name="toDelete" value="{{$lawsProject->id}}" class="checkDelete " />
            </label>
            @if(!$lawsProject->law_type)
                {{ $lawsProject->law_type_id }}
            @else
                {!! mb_strtoupper($lawsProject->law_type->name, 'UTF-8') !!}
            @endif

            <span id="tdLawProjectNumber{{$lawsProject->id}}">
                {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!}
            </span>
        </span>
    </div>
    <div class="panel-body" style="font-size: 12px">
        <div class="col-md-4">
            <span>
                <strong>COD:</strong>
                {!! $lawsProject->getNumberLaw() == 'false'  ? '-'  : $lawsProject->getNumberLaw() !!}
            </span>
            <br>
            <span>
                <strong>Data: </strong>
                {{$lawsProject->law_date}}
            </span>
            <br>
            <span>
                <strong>Protocolo: </strong>
                <span id="tdLawProtocol{{$lawsProject->id}}" align="center">
                    @if($lawsProject->project_number > 0)
                        {{ $lawsProject->protocol }} - {{$lawsProject->protocoldate}}
                    @elseif(
                        Auth::user()
                            ->roleHasPermission('lawsProject.createLawProjectNumber')
                    )
                        <button
                            type="button"
                            class="btn btn-default btn-xs btn-protocol"
                            value="{!! $lawsProject->id !!}"
                        >
                            <i class="glyphicon glyphicon-folder-open"></i>
                        </button>
                    @endif
                </span>
            </span>
            <br>
            <span>
                <strong> Aprovado: </strong>

                @if($lawsProject->is_ready === 1)
                    <span id="tdLawApproved_{{$lawsProject->id}}">
                            {{$lawsProject->law_number}} - {{$lawsProject->law_date_publish}}
                        </span>

                    @shield('lawProject.approvedEdit')
                    <button type="button" class="btn btn-warning btn-xs" onclick="approvedEdit('{{ $lawsProject->id }}')">
                                <i class="fa fa-pencil"></i>
                            </button>
                    @endshield
                @else
                    @shield('lawsProject.approved')
                    <span id="tdLawApproved{{$lawsProject->id}}" align="center">
                                <button type="button" class="btn btn-default btn-xs btn-approved" value="{!! $lawsProject->id !!}">
                                    <i class="glyphicon glyphicon-folder-open"></i>
                                </button>
                            </span>
                    @endshield
                @endif
            </span>
        </div>
        <div class="col-md-4">
            <span>
                <strong>Responsável: </strong>

                    @if($lawsProject->owner)
                    {{ $lawsProject->owner->short_name }}
                @else
                    -
                @endif
            </span>
            <br>
            <span>
                <strong>Comissão: </strong>

                @if($lawsProject->comission)
                    {{ $lawsProject->comission->name }}
                @else
                    -
                @endif
            </span>
            <br>
            <span>
                <strong>Referente à: </strong>

                @if($lawsProject->reference_id > 0)
                    <a href="/lawsProjects/{{$lawsProject->reference_id}}" target="_blank">
                        {{--{{ \App\Models\LawsProject::find($lawsProject->reference_id)->project_number}}/--}}
                        {{--{{\App\Models\LawsProject::find($lawsProject->reference_id)->getYearLaw($lawsProject->law_date)}} ---}}
                        {{--{{ \App\Models\LawsProject::find($lawsProject->reference_id)->law_type->name}}--}}
                    </a>
                @endif
            </span>
            <br>
            <span>
                <strong>Aprovado pela câmara: </strong>

                {{ $lawsProject->town_hall ? 'Sim' : 'Não' }}
            </span>
        </div>
        <div class="col-md-4">
            <span>
                <strong>Aprovado pela câmara:</strong>
                <br>
                <label>
                    <input
                        type="checkbox"
                        id ='town_hall{{$lawsProject->id}}'
                        onchange='toogleApproved({{$lawsProject->id }})'
                        class='form-control switch'
                        data-on-text='Sim'
                        data-off-text='Não'
                        data-off-color='danger'
                        data-on-color='success'
                        data-size='normal'
                        @if($lawsProject->town_hall == 1)
                        checked
                        @endif
                    >
                </label>
            </span>
            <br>
            <span>
                <strong>Lida:</strong>

                @shield('lawsProject.read')
                    <label>
                        <input
                            onchange="changeRead('{!! $lawsProject->id !!}')"
                            type="checkbox" {!! $lawsProject->is_read > 0 ? 'checked' : '' !!}
                        >
                    </label>
                @endshield
            </span>
        </div>

        <div class="col-md-12" style="height: 80px">
            <br>
            <span style="text-align: justify !important;" class="text-uppercase">
                <strong>Ementa:</strong>
                <br>
                {!! $lawsProject->title !!}
            </span>
            <br>
        </div>

        <div class="col-md-12">
            <span>
                <strong>Data Tram.:</strong>

                @if(count($lawsProject->processing)===0)
                    -
                @else
                    {!!
                        $lawsProject->processing->first()
                            ->processing_date
                    !!}
                @endif
            </span>
            <br>
            <span>
                <strong>Status:</strong>

                @if(count($lawsProject->processing)===0)
                    -
                @else
                    {!!
                        $lawsProject->processing->first()
                            ->statusProcessingLaw->name
                    !!}
                @endif
            </span>
            <br>
            <span>
                <strong>Destinatário:</strong>

                @if(count($lawsProject->processing)===0)
                    -
                @else
                    {!!
                        $lawsProject->processing->first()
                            ->destination->name
                    !!}
                @endif
            </span>
        </div>
    </div>
    <div class="panel-footer">
        {!! Form::open(['route' => ['lawsProjects.destroy', $lawsProject->id], 'method' => 'delete']) !!}
        <div class='btn-group col-md-12'>
            @shield('lawsProject.advices')
                <a href="{!! route('lawsProjects.advices', [$lawsProject->id]) !!}" class='btn btn-default btn-sm'>
                    TRÂMITES
                </a>
            @endshield

            <a
                href="{!! route('lawsProjects.legal-opinion', [$lawsProject->id]) !!}"
                class='btn btn-default btn-sm'
            >
                PARECERES
            </a>

            @shield('lawsProjects.edit')
                <a href="{!! route('lawsProjects.structure', [$lawsProject->id]) !!}" class='btn btn-default btn-sm'>
                    ESTRUTURA DA LEI
                </a>
            @endshield

            @shield('lawsProject.editprotocollei','lawsProject.editnumerolei')
                <a href="javascript:void(0)" class='btn btn-default btn-sm' onclick="editNumero({{$lawsProject->id}})">
                    ALTERAR NÚMERO/PROTOCOLO
                </a>
            @endshield

            @if($lawsProject->law_file)
                <a href="/laws/{{ $lawsProject->law_file }}" target="_blank" class='btn btn-default btn-sm'>
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </a>
            @endif

            @shield('lawsProjects.show')
                <a
                    href="{!! route('lawsProjects.show', [$lawsProject->id]) !!}"
                    target="_blank"
                    class='btn btn-default btn-sm'
                >
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>
            @endshield

            @if($lawsProject->file)
                <a href="/laws/{{ $lawsProject->file }}" target="_blank" class='btn btn-default btn-sm'>
                    <i class="fa fa-paperclip"></i>
                </a>
            @endif

            @if($lawsProject->voting)
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#votes_{{ $lawsProject->id }}">
                    VOTAÇÃO
                </button>
            @endif

            @shield('lawsProjects.edit')
                <a href="{!! route('lawsProjects.edit', [$lawsProject->id]) !!}" class='btn btn-warning btn-sm'>
                    <i class="glyphicon glyphicon-edit"></i>
                </a>
            @endshield

            @shield('lawsProjects.delete')
                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
            @endshield

            <a href="/lawproject/{{$lawsProject->id}}/addFiles" class="pull-right btn btn-info btn-sm">
                <i class="fa fa-plus"></i> Anexos
            </a>
        </div>
        <div class="clearfix"></div>
        {!! Form::close() !!}
    </div>
</div>
@if($lawsProject->voting)
    <div class="modal fade" id="votes_{{ $lawsProject->id }}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content modal-no-shadow">
                <div class="modal-header bg-dark no-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">
                        VOTACÃO :

                        @if(!$lawsProject->law_type)
                            {{ $lawsProject->law_type_id }}
                        @else
                            {!! mb_strtoupper($lawsProject->law_type->name, 'UTF-8') !!}
                        @endif

                        <span id="tdLawProjectNumber{{$lawsProject->id}}">
                            {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!}
                        </span>
                    </h4>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="list_votacao">
                        @foreach($lawsProject->voting()->get() as $item)
                            <li class="list-group-item">
                                Data da votação : {{ date("d/m/Y", strtotime($item->open_at))}}

                                <span class="pull-right @if($item->situation($item)) text-primary @else text-danger @endif" >
                                    @if($item->situation($item))
                                        Votação Aprovada
                                    @else
                                        Votação Reprovada
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div><!-- /.modal-footer -->
            </div><!-- /.modal-content .modal-no-shadow -->
        </div><!-- /.modal-dialog -->
    </div>
@endif
