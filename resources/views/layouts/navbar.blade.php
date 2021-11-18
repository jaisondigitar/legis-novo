<ul class="nav navbar-nav">
    @is(['root'])
        <li class="dropdown ">
            <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs">Configurações</span>
                <span class="visible-xs">Config</span>
            </a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @is('root')
                    @shield('modules.index')
                        <li><a href="{{url('/config/modules', $parameters = [], $secure = null)}}"><i class="fa fa-cubes"></i>Módulos</a></li>
                    @endshield
                    @shield('permissions.index')
                        <li><a href="{{url('/config/permissions', $parameters = [], $secure = null)}}"><i class="fa fa-key"></i>Permissões</a></li>
                    @endshield
                    @shield('parameters.index')
                        <li><a href="{{url('/config/parameters', $parameters = [], $secure = null)}}"><i class="fa fa-sliders"></i>Parâmetros</a></li>
                    @endshield
                    @shield('documents.importNumber')
                        <li><a href="{{url('/config/importNumber', $parameters = [], $secure = null)}}"><i class="fa fa-file"></i>Migrar número de documento</a></li>
                    @endshield
                    @shield('lawsProjects.importNumberLaw')
                        <li><a href="{{url('/config/importNumberLaw', $parameters = [], $secure = null)}}"><i class="fa fa-gavel"></i>Migrar número da lei</a></li>
                    @endshield
                @endis
            </ul>
        </li>
    @endis

    @if(App::make("ModuleService")->isActive('Geral'))
    <li>
        <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"><span>Geral</span></a>
        <ul class="dropdown-menu square margin-list-rounded with-triangle">
            @is(['root','admin'])<li><a href="{{url('/config/companies', $parameters = [], $secure = null)}}"><i class="fa fa-bank"></i> Instituição</a></li>@endis
            @shield('users.index')
            <li><a href="{{url('/users', $parameters = [], $secure = null)}}"><i class="fa fa-users"></i> Usuarios</a></li>
            @endshield
            <li class="divider"></li>
            @is(['root','admin'])<li><a href="{{url('/importer/sgl', $parameters = [], $secure = null)}}"><i class="fa fa-upload"></i> Importador de documentos</a></li>@endis
            @is(['root','admin'])<li><a href="{{url('/importer/projects', $parameters = [], $secure = null)}}"><i class="fa fa-upload"></i> Importador de projetos de lei</a></li>@endis
            <li class="divider"></li>
            @shield('roles.index')<li><a href="{{url('/gerencial/roles', $parameters = [], $secure = null)}}"><i class="fa fa-cog"></i> Grupos de Permissões</a></li>@endshield
            @is(['root','admin'])<li><a href="{{url('/logs', $parameters = [], $secure = null)}}"><i class="fa fa-cog"></i> Auditoria</a></li>@endis
            <li class="divider"></li>
            @is(['root','admin'])<li><a href="{{url('/config/export/files', $parameters = [], $secure = null)}}"><i class="fa fa-cog"></i> Exportar Documentos </a></li>@endshield
        </ul>
    </li>
    @endif

    @if(App::make("ModuleService")->isActive('Cadastro'))
        <li>
            <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"><span>Cadastro</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('assemblymen.index')<li class=""><a href="{{url('/assemblymen', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Parlamentar</a></li>@endshield

                {{--@shield('protocolTypes.index')<li class=""><a href="{{url('/protocolTypes', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Tipo de Protocolos</a></li>@endshield--}}
                <li class="divider"></li>
                @shield('legislatures.index')<li class=""><a href="{{url('/legislatures', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Legislatura</a></li>@endshield
                @shield('parties.index')<li class=""><a href="{{url('/parties', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Partidos</a></li>@endshield
                @shield('responsibilities.index')<li class=""><a href="{{url('/responsibilities', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Responsabilidade</a></li>@endshield
                @shield('sectors.index')<li class=""><a href="{{url('/sectors', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Setores</a></li>@endshield
            </ul>
        </li>
    @endif

    @if(App::make("ModuleService")->isActive('Documentos'))
    <li>
        <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"><span>Documentos</span></a>
        <ul class="dropdown-menu square margin-list-rounded with-triangle">
            @shield('documents.index')<li class=""><a href="{{url('/documents', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Documentos</a></li>@endshield
            <li class="divider"></li>
            @shield('adviceSituationDocuments.index')<li class=""><a href="{{url('/adviceSituationDocuments', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Situação do paracer do documento</a></li>@endshield
            @shield('advicePublicationDocuments.index')<li class=""><a href="{{url('/advicePublicationDocuments', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Publicação do paracer do documento</a></li>@endshield
            @shield('documentModels.index')<li class=""><a href="{{url('/documentModels', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Modelos de documentos</a></li>@endshield
            @shield('documentTypes.index')<li class=""><a href="{{url('/documentTypes', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Tipos de documentos</a></li>@endshield
            @shield('documentSituations.index')<li class=""><a href="{{url('/documentSituations', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Situação do documentos</a></li>@endshield
            @shield('statusProcessingDocuments.index')<li class=""><a href="{{url('/statusProcessingDocuments', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Status do tramite</a></li>@endshield
        </ul>
    </li>
    @endif

    @if(App::make("ModuleService")->isActive('Comissoes'))
    <li>
        <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"><span>Comissões</span></a>
        <ul class="dropdown-menu square margin-list-rounded with-triangle">
            @shield('commissions.index')<li class=""><a href="{{url('/commissions', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Comissões</a></li>@endshield
            <li class="divider"></li>
            @shield('officeCommissions.index')<li class=""><a href="{{url('/officeCommissions', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Cargo de comissão</a></li>@endshield
            @shield('comissionSituations.index')<li class=""><a href="{{url('/comissionSituations', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Situações de pareceres</a></li>@endshield
        </ul>
    </li>
    @endif

    @if(App::make("ModuleService")->isActive('Sessoes'))
        <li>
            <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"><span>Sessões</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('meetings.index')<li class=""><a href="{{url('/meetings', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Sessões</a></li>@endshield
                <li class="divider"></li>
                @if(\Illuminate\Support\Facades\Auth::user()->sector->slug == 'gabinete')
                    <li>
                        @if(Auth::user()->assemblyman_count())
                            <a href="/voting/assemblyman/{{Auth::user()->get_assemblyman()}}">
                                <i class="fa fa-list"></i> Votação
                            </a>
                        @else
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#select_gabinete">
                                <i class="fa fa-list"></i> Votação
                            </a>
                        @endif
                    </li>
                @endif
                @shield('version_pauta.index')<li class=""><a href="{{url('/version_pauta', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Estrutura de Pauta</a></li>@endshield
                @shield('sessionTypes.index')<li class=""><a href="{{url('/sessionTypes', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Tipo de Sessões</a></li>@endshield
                {{--@shield('structurepautas.index')<li class=""><a href="{{url('/structurepautas', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Estrutura de Pauta</a></li>@endshield--}}
                @shield('structurepautas.index')<li class=""><a href="{{url('/typeVotings', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Tipo de vontação</a></li>@endshield

            </ul>
        </li>
    @endif

    @if(App::make("ModuleService")->isActive('Leis'))
        <li>
            <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"><span>Projeto de Lei</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('lawsProjects.index')<li class=""><a href="{{url('/lawsProjects', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Projeto de lei</a></li>@endshield
                <li class="divider"></li>
                @shield('lawSituations.index')<li class=""><a href="{{url('/lawSituations', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Situação de lei</a></li>@endshield
                @shield('adviceSituationLaws.index')<li class=""><a href="{{url('/adviceSituationLaws', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Situação do paracer da lei</a></li>@endshield
                @shield('advicePublicationLaws.index')<li class=""><a href="{{url('/advicePublicationLaws', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Publicação do paracer da lei</a></li>@endshield
                @shield('statusProcessingLaws.index')<li class=""><a href="{{url('/statusProcessingLaws', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Status do Tramite</a></li>@endshield
                @shield('lawsTypes.index')<li class=""><a href="{{url('/lawsTypes', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Tipos de lei</a></li>@endshield
                @shield('lawsTags.index')<li class=""><a href="{{url('/lawsTags', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Tags de lei</a></li>@endshield
                @shield('lawsStructures.index')<li class=""><a href="{{url('/lawsStructures', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Tipo de estruturas de lei</a></li>@endshield
                @shield('lawsPlaces.index')<li class=""><a href="{{url('/lawsPlaces', $parameters = [], $secure = null)}}"><i class="fa fa-check"></i> Locais publicação</a></li>@endshield
            </ul>
        </li>
    @endif


    <li class="">
        <a href="fakelink" class="dropdown-toggle" data-toggle="dropdown">Relatórios</a>
        <ul class="dropdown-menu square margin-list-rounded with-triangle">
           <li class=""><a href="/report/documents"> <i class="fa fa-check"></i> Documentos</a></li>
           <li class=""><a href="/report/documents/noFiles"> <i class="fa fa-check"></i> Documentos sem arquivos</a></li>
            <li class="divider"></li>
            <li class=""><a href="/report/lawsProject"> <i class="fa fa-check"></i> Projetos de lei</a></li>
            <li class=""><a href="/report/lawsProject/noFiles"> <i class="fa fa-check"></i> Projeto de lei sem arquivos</a></li>
            <li class="divider"></li>
            <li class=""><a href="/report/meeting/noFiles"> <i class="fa fa-check"></i> Pautas/ATA sem arquivos</a></li>
            <li class="divider"></li>
            <li class=""><a href="/report/getTramitacao"> <i class="fa fa-check"></i> Projetos de lei / Tramitacao</a></li>

        </ul>
    </li>
    <li><a href="https://www.genesis.tec.br/" target="_blank"> Ajuda </a></li>
</ul>



