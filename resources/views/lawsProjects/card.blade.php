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
            -
            <span id="tdLawProjectNumber{{$lawsProject->id}}" style="color: #37BC9B">
                @if($lawsProject->project_number)
                    @if (Auth::user()->roleHasPermission('lawsProject.editnumerolei'))
                        <a
                            href="javascript:void(0)"
                            id="numberEdit{{$lawsProject->id}}"
                            onclick="alteraNumber('{{ $lawsProject->id }}');"
                        >
                            {!!$lawsProject->project_number . '/' .$lawsProject->getYearLawPublish($lawsProject->law_date)!!}
                        </a>
                    @else
                        <span style="color: #37BC9B">
                            {!!$lawsProject->project_number . '/' .$lawsProject->getYearLawPublish($lawsProject->law_date)!!}
                        </span>
                    @endif
                @else
                    -
                @endif
            </span>
            <div class="pull-right">
                Prazo:

                @if(isset($lawsProject->processing->first()->date_end))
                    <?php
                        $input = $lawsProject->processing->first()->date_end;
                        $date = implode('-', array_reverse(explode('/', $input)));

                        $diff = strtotime($date) - strtotime(date('Y-m-d'));
                        $dateDiff = $diff / (60 * 60 * 24);

                        if ($dateDiff <= 0) {
                            echo '<div class="pull-right" style = "color: #c71111; margin-left: 5px">'.
                                $input
                                .'</div>';
                        } elseif ($dateDiff === 1 || $dateDiff === 2) {
                            echo '<div class="pull-right" style="color: #ff7300; margin-left: 5px">'.
                                $input
                                .'</div>';
                        } else {
                            echo '<div class="pull-right" style="margin-left: 5px">'.
                                $input
                                .'</div>';
                        }
                    ?>
                @else
                    -
                @endif

            </div>
        </span>
    </div>
    <div class="panel-body" style="font-size: 12px; height: 260px">
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
                <span id="tdLawProtocol{{$lawsProject->id}}" style="color: #37BC9B" align="center">
                    @if($lawsProject->protocol > 0)
                        {{ $lawsProject->protocol }} - {{$lawsProject->protocoldate}}
                    @elseif(Auth::user()->roleHasPermission('lawsProject.createLawProjectNumber'))
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

                @if($lawsProject->is_ready >= 1)
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
        <div class="col-md-6">
            <span>
                <strong>Respons??vel: </strong>

                @if($lawsProject->owner)
                    {{ $lawsProject->owner->short_name }}
                @else
                    -
                @endif
            </span>
            <br>
            <span>
                <strong>Comiss??o: </strong>

                @if($lawsProject->comission)
                    {{ $lawsProject->comission->name }}
                @else
                    -
                @endif
            </span>
            <br>
            <span>
                <strong>Referente ??: </strong>

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
                <strong>Aprovado pela c??mara: </strong>

                {{ $lawsProject->town_hall ? 'Sim' : 'N??o' }}
            </span>
        </div>
        <div class="col-md-2">
            <span>
                <strong>Aprova????o:</strong>
                <br>
                <label>
                    <input
                        type="checkbox"
                        id ='town_hall{{$lawsProject->id}}'
                        onchange='toogleApproved({{$lawsProject->id }})'
                        class='form-control switch'
                        data-on-text='Sim'
                        data-off-text='N??o'
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

        <div class="col-md-12" style="height: 100px">
            <br>
            <span style="text-align: justify !important;" class="text-uppercase">
                <strong>Ementa:</strong>

                @if($lawsProject->title === '')
                    -
                @else
                    <p class="resume">
                        {!! $lawsProject->title !!}
                    </p>
                @endif
            </span>
            <br>
        </div>
        <div class="col-md-12">
            <span>
                <strong>Data Tram.:</strong>
                @if($lawsProject->processing->isEmpty())
                    -
                @else
                    {!!
                        $lawsProject->processing->first()->processing_date
                    !!}
                @endif
            </span>
            <br>
            <span>
                <strong>Status:</strong>

                @if($lawsProject->processing->isEmpty())
                    -
                @else
                    {!!
                        $lawsProject->processing->first()->adviceSituationLaw->name
                    !!}
                @endif
            </span>
            <br>
            <span>
                <strong>Destinat??rio:</strong>

                @if($lawsProject->processing->isEmpty())
                    -
                @else
                    {!!
                        $lawsProject->processing->first()->destination->name
                    !!}
                @endif
            </span>
        </div>
    </div>
    <div class="panel-footer">
        @if(!$lawsProject->protocol)
            <span class="badge badge-warning pull-left">Aberto</span>
        @else
            <span class="badge badge-info pull-left">Protocolado</span>
        @endif

        {!! Form::open(['route' => ['lawsProjects.destroy', $lawsProject->id], 'method' => 'delete']) !!}
        <div class='btn-group action'>
            @shield('lawsProjects.show')
                <a @popper(GERAR PDF) href="{!! route('lawsProjects.show', [$lawsProject->id]) !!}" target="_blank" class='btn btn-default btn-sm'>
                    <i class="far fa-eye"></i>
                </a>
            @endshield

            @if($lawsProject->town_hall == 1 && $lawsProject->is_read > 0 && Auth::user()->can_request_executive_not_root || Auth::user()->hasRole('root'))
                <a @popper(RESPONDER) onclick="answer({{ $lawsProject }})" class='btn btn-default btn-sm answer' value="{!! $lawsProject->id !!}">
                    <i class="fa fa-reply"></i>
                </a>
            @endif

            @if(!Auth::user()->can_request_executive_not_root || Auth::user()->hasRole('root'))
                @shield('lawsProject.advices')
                    <a @popper(TR??MITA????O) href="{!! route('lawsProjects.advices', [$lawsProject->id]) !!}" class='btn btn-default btn-sm'>
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </a>

                    <a @popper(PARECERES) href="{!! route('lawsProjects.legal-option', [$lawsProject->id]) !!}" class='btn btn-default btn-sm'>
                        <i class="fa fa-clipboard"></i>
                    </a>
                @endshield

                {{--Retirada de Bot??es sem Utilidade--}}

                {{--@if(Auth::user()->id == $lawsProject->owner->id || Auth::user()->hasRole('root'))
                    @shield('lawsProjects.edit')
                        <a @popper(ESTRUTURA DE LEI) href="{!! route('lawsProjects.structure', [$lawsProject->id]) !!}" class='btn btn-default btn-sm'>
                            <i class="fas fa-gavel"></i>
                        </a>
                    @endshield
                @endif--}}

                {{--@shield('lawsProject.editprotocollei','lawsProject.editnumerolei')
                    <a @popper(ALTERAR N??MERO/PROTOCOLO) href="javascript:void(0)" class='btn btn-default btn-sm' onclick="editNumero({{$lawsProject->id}})">
                       <i class="fas fa-project-diagram"></i>
                    </a>
                @endshield--}}

                @if($lawsProject->law_file)
                    <a href="/laws/{{ $lawsProject->law_file }}" target="_blank" class='btn btn-default btn-sm'>
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </a>
                @endif

                @if($lawsProject->file)
                    <a href="/laws/{{ $lawsProject->file }}" target="_blank" class='btn btn-default btn-sm'>
                        <i class="fa fa-paperclip"></i>
                    </a>
                @endif

                @if($lawsProject->voting)
                    <a @popper(VOTA????O) type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#votes_{{ $lawsProject->id }}">
                        <i class="fas fa-vote-yea"></i>
                    </a>
                @endif

                <a @popper(ANEXOS) href="/lawproject/{{$lawsProject->id}}/addFiles" class="btn btn-default btn-sm">
                    <i class="fas fa-paperclip"></i>
                </a>

                @if($lawsProject->owner->short_name === Auth::user()->name || Auth::user()->hasRole('root'))
                    @shield('lawsProjects.edit')
                        <a @popper(EDITAR) href="{!! route('lawsProjects.edit', [$lawsProject->id]) !!}" class='btn btn-default btn-sm'>
                            <i class="fa fa-edit"></i>
                        </a>
                    @endshield
                @endif

                @if(!$lawsProject->protocol && $lawsProject->owner->short_name === Auth::user()->name || Auth::user()->hasRole('root'))
                    @shield('lawsProjects.delete')
                        <a @popper(REMOVER)>
                            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'sweet(event)']) !!}
                        </a>
                    @endshield
                @endif
            @endif
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                    <h4 class="modal-title">
                        VOTAC??O :

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
                                Data da vota????o : {{ date("d/m/Y", strtotime($item->open_at))}}

                                <span class="pull-right @if($item->situation($item)) text-primary @else text-danger @endif" >
                                    @if($item->situation($item))
                                        Vota????o Aprovada
                                    @else
                                        Vota????o Reprovada
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

<script>
    function sweet (e) {
        var url = `/lawsProject/{{$lawsProject->id}}`;

        var data = {
            '_token' : '{{csrf_token()}}'
        };

        sweetDelete(e, url, data)
    }
</script>
