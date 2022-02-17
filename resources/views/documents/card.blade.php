<div class="card">
    <div class="card-header" style="text-align: center; font-size: 15px;">
        <span class="panel-title text-uppercase">
            <span class="panel-title text-uppercase">
                <label class="pull-right">
                    <input type="checkbox" name="toDelete" value="{{$document->id}}" class="checkDelete"/>
                </label>

                <label class="pull-left">
                    <i class="fa fa-file" style="margin-right: 5px;"></i>

                    @if($document->document_type->parent_id)
                        {{ $document->document_type->parent->name }} ::
                    @endif
                        {!! $document->document_type->name !!} -
                    @if($document->number === 0)
                        -
                    @elseif($document->number !== 0)
                        @if (Auth::user()->roleHasPermission('document.editnumero'))
                            <a
                                href="javascript:void(0)"
                                id="numberEdit{{$document->id}}"
                                onclick="alteraNumero('{{ $document->id }}');"
                            >
                                {!!
                                    $document->number
                                !!}{!!
                                    '/' . $document->getYear($document->date)
                                !!}
                            </a>
                        @else
                            <span style="color: #37BC9B">
                                {!!
                                    $document->number
                                !!}{!!
                                    '/' . $document->getYear($document->date)
                                !!}
                            </span>
                        @endif
                    @else
                        @if (Auth::user()->roleHasPermission('document.editnumero'))
                            <span style="color: #37BC9B">
                                {!!
                                    $document->number . '/' . $document->getYear($document->date)
                                !!}
                            </span>
                        @endif
                    @endif
                </label>

                <label>
                    <span>
                        {!! $document->date !!}
                    </span>
                </label>
            </span>
        </span>
    </div>
    <div class="card-body">
        <span class="row" style="font-size: 13px;">
            <div class="col-sm-6">
                <span class="text-uppercase">
                    <label>
                        <i class="fa fa-user"></i> @if($document->owner) {!! $document->owner->short_name !!} @else - @endif <br>
                    </label>
                </span>
                <br>
                <span>
                    <label>
                        <strong>Número:</strong>
                        <span id="tdnumber{{$document->id}}">
                            @if($document->number === 0)
                                -
                            @elseif($document->number !== 0)
                                @if (Auth::user()->roleHasPermission('document.editnumero'))
                                    <a
                                        href="javascript:void(0)"
                                        id="numberEdit{{$document->id}}"
                                        onclick="alteraNumero('{{$document->id}}');"
                                    >
                                        {!!
                                            $document->number !!}{!!'/' . $document->getYear($document->date)
                                        !!}
                                    </a>
                                @else
                                    <span style="color: #37BC9B">
                                        {!!
                                            $document->number
                                        !!}{!!
                                            '/' . $document->getYear($document->date)
                                        !!}
                                    </span>
                                @endif
                            @else
                                @if (Auth::user()->roleHasPermission('document.editnumero'))
                                    <span style="color: #37BC9B">
                                        {!!
                                            $document->number
                                        !!}{!!
                                            '/' . $document->getYear($document->date)
                                        !!}
                                    </span>
                                @endif
                            @endif
                        </span>
                    </label>
                </span>
                <br>
                <span>
                    <label>
                        <strong>Protocolo: </strong>
                        <span id="tdprotocol{{$document->id}}">
                            @if (
                                !$document->document_protocol &&
                                !Auth::user()->roleHasPermission('document.createProtocolNumber')
                            )
                                -
                            @elseif (
                                !$document->document_protocol &&
                                Auth::user()->roleHasPermission('document.createProtocolNumber')
                            )
                                <button type="button" class="btn btn-xs btn-protocol" value="{!! $document->id !!}">
                                    <span align="center">
                                        <i class="fas fa-folder-open"></i>
                                    </span>
                                </button>
                            @else
                                @if (Auth::user()->roleHasPermission('document.editprotocol'))
                                    <a
                                        href="javascript:void(0)"
                                        id='linkProtocolo{{$document->id}}'
                                        onclick="alteraProtocolo(
                                            '{!!$document->id!!}',
                                            '{{
                                                date('d/m/Y H:i:s',
                                                strtotime(
                                                    $document->document_protocol->created_at
                                                ))
                                            }}'
                                            );"
                                    >
                                        @if($document->document_protocol)
                                            {{$document->document_protocol->number}}
                                        @endif
                                    </a>
                                @else
                                    <span style="color: #37BC9B">
                                        @if($document->document_protocol)
                                            {{$document->document_protocol->number}}
                                        @endif
                                    </span>
                                @endif
                            @endif
                        </span>
                    </label>
                </span>
            </div>
            <div class="col-md-6">
                @shield('document.read')
                    <label for="lido_{{$document->id}}">
                        <strong>Lido:</strong>
                        <input id="lido_{{$document->id}}" type="checkbox" onclick="changeRead('{!! $document->id !!}')" {!! $document->read > 0 ? 'checked' : '' !!}>
                    </label>
                @endshield
                @shield('document.approved')
                    <span>
                        <label>
                        <strong>Aprovado:</strong>
                            <input onchange="changeApproved('{!! $document->id !!}')" type="checkbox" {!! $document->approved > 0 ? 'checked' : '' !!} >
                        </label>
                    </span>
                @endshield
                <br>
                <label>
                    <strong>Data Prot.:</strong>
                    <span>
                        @if($document->document_protocol)
                            {{date('d/m/Y', strtotime($document->document_protocol->created_at))}}
                        @else
                            -
                        @endif
                    </span>
                </label>
                <br>
                <label>
                    <strong>Setor:</strong>
                    <span>
                        @if($document->externalSector)
                            {{$document->externalSector->name}}
                        @else
                            -
                        @endif
                    </span>
                </label>
            </div>
            <div class="col-sm-12">
                <label style="margin-top: 10px; min-height: 8rem">
                    <strong>Ementa:</strong>
                    <span>
                        @if($document->resume === '')
                            -
                        @else
                            <p class="resume">
                                {!! $document->resume !!}
                            </p>
                        @endif
                    </span>
                </label>
            </div>
            <div class="col-sm-12">
                <span>
                    <label>
                        <strong>Data Tram.:</strong>
                        <span>
                            @if(count($document->processingDocument)===0)
                                -
                            @else
                                {!!
                                    $document->processingDocument->first()
                                        ->processing_document_date
                                !!}
                            @endif
                        </span>
                    </label>
                </span>
                <br>
                <span>
                    <label>
                        <strong>Status:</strong>
                        <span>
                            @if(count($document->processingDocument)===0)
                                -
                            @else
                                {!!
                                    $document->processingDocument->first()
                                        ->documentSituation->name
                                !!}
                            @endif
                        </span>
                    </label>
                </span>
                <br>
                <label>
                    <strong>Destinatário:</strong>
                    <span>
                        @if(count($document->processingDocument)===0)
                            -
                        @else
                            {!! $document->processingDocument->first()->destination->name !!}
                        @endif
                    </span>
                </label>
            </div>
        </span>
    </div>
    <div class="card-footer">
        @if(!$document->document_protocol)
            <span class="badge badge-warning pull-left">Aberto</span>
        @else
            <span class="badge badge-info pull-left">Protocolado</span>
        @endif
        {!! Form::open(['route' => ['documents.destroy', $document->id], 'method' => 'delete']) !!}

        <div class='btn-group action' id="tdoptions{{$document->id}}">
            @shield('documents.show')
                <a @popper(GERAR PDF) href="{!! route('documents.show', [$document->id]) !!}" target="_blank" class='btn btn-default btn-xs'>
                    <i class="fa fa-file-pdf-o"></i>
                </a>
            @endshield

            @if($document->read > 0 && $document->approved > 0 && Auth::user()->can_request_executive_not_root || Auth::user()->hasRole('root'))
                <a @popper(RESPONDER) onclick="answer()" class='btn btn-default btn-xs answer'>
                    <i class="fa fa-reply"></i>
                </a>
            @endif

            @if(!Auth::user()->can_request_executive_not_root || Auth::user()->hasRole('root'))
                @shield('documents.advices')
                    <a @popper(TRÂMITAÇÃO) href="{!! route('documents.advices', [$document->id]) !!}" class='btn btn-default btn-sm'>
                        <i class="fa fa-list-alt"></i>
                    </a>

                    <a @popper(PARECERES) href="{!! route('documents.legal-option', [$document->id]) !!}" class='btn btn-default btn-sm'>
                        <i class="fa fa-clipboard"></i>
                    </a>
                @endshield

                @shield('documents.edit')
                    <a @popper(ANEXAR ARQUIVO) href="{!! route('documents.attachament', [$document->id]) !!}" class='btn btn-default btn-sm'>
                        <i class="fas fa-paperclip"></i>
                    </a>
                @endshield

                @if($document->users_id === Auth::user()->id || Auth::user()->hasRole('root'))
                    @shield('documents.edit')
                        <a @popper(EDITAR) href="{!! route('documents.edit', [$document->id]) !!}" class='btn btn-default btn-sm'>
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    @endshield
                @endif

                @if(!$document->document_protocol && $document->users_id === Auth::user()->id || Auth::user()->hasRole('root'))
                    @shield('documents.delete')
                       <a @popper(REMOVER)
                           type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i>
                       </a>
                    @endshield
                @endif
            @endif
        </div>
        <div class="clearfix"></div>
        {!! Form::close() !!}
    </div>
</div>
