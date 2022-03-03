<style>
    .space {
        margin-right: 0.5rem;
    }
    .courser {
        cursor: pointer;
    }
    .navbar {
        border-radius: 0;
    }
    .dropdown-item {
        font-size: 15px;
    }
    .dropdown-toggle::after {
        padding-left: 20px;
        content: none;
    }
    .dropdown {
        padding-right: 15px;
    }

    #navbar-brand{
        margin: 0 0 0 3.688rem;
        color: #0A0A0A;
        font-size: 20px;
        display: flex;
        align-items: center;
    }

    .NewNavbar {
        margin: 0 0 0 25rem;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a id="navbar-brand" href="/admin">
            GPL
        </a>
        <div class="collapse navbar-collapse NewNavbar" id="navbarSupportedContent"
        >
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @is(['root'])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navConfig" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>
                                Configurações
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            @is('root')
                                @shield('modules.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/config/modules', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-cubes space"></i>Módulos
                                        </a>
                                    </li>
                                @endshield
                                @shield('permissions.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/config/permissions', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-key space"></i>Permissões
                                        </a>
                                    </li>
                                @endshield
                                @shield('parameters.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/config/parameters', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-sliders space"></i>Parâmetros
                                        </a>
                                    </li>
                                @endshield
                                @shield('documents.importNumber')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/config/importNumber', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-file space"></i>Migrar número de documento
                                        </a>
                                    </li>
                                @endshield
                                @shield('lawsProjects.importNumberLaw')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/config/importNumberLaw', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-gavel space"></i>Migrar número da lei
                                        </a>
                                    </li>
                                @endshield
                            @endis
                        </ul>
                    </li>
                @endis

                @shield('destination.index', 'users.index', 'roles.index')
                    @if(App::make("ModuleService")->isActive('Geral'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    Geral
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @is(['root','admin'])
                                    <li>
                                        <a class="dropdown-item" href="{{url('/config/companies', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-bank space"></i>Instituição
                                        </a>
                                    </li>
                                @endis

                                @shield('destination.index')
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/destinations', $parameters = [], $secure = null) }}">
                                            <i class="fa fa-user space"></i>Destinatários
                                        </a>
                                    </li>
                                @endshield

                                @shield('users.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/users', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-users space"></i>Usuários
                                        </a>
                                    </li>

                                <li><hr class="dropdown-divider"></li>
                                @endshield

                                @is(['root','admin'])
                                    <li>
                                        <a class="dropdown-item" href="{{url('/importer/sgl', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-upload space"></i>Importador de documentos
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{url('/importer/projects', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-upload space"></i>Importador de projetos de lei
                                        </a>
                                    </li>

                                <li><hr class="dropdown-divider"></li>
                                @endis

                                @shield('roles.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/gerencial/roles', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-cog space"></i>Grupos de Permissões
                                        </a>
                                    </li>
                                @endshield

                                @is(['root','admin'])
                                    <li>
                                        <a class="dropdown-item" href="{{url('/logs', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-cog space"></i>Auditoria
                                        </a>
                                    </li>

                                <li><hr class="dropdown-divider"></li>

                                    <li>
                                        <a class="dropdown-item" href="{{url('/config/export/files', $parameters = [], $secure = null)}}">
                                            <i class="fa fa-cog space"></i>Exportar Documentos
                                        </a>
                                    </li>
                                @endis
                            </ul>
                        </li>
                    @endif
                @endshield

                @shield('assemblymen.index', 'legislatures.index', 'parties.index', 'responsibilities.index', 'sectors.index')
                    @if(App::make("ModuleService")->isActive('Cadastro'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    Cadastro
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @shield('assemblymen.index')
                                <li>
                                    <a class="dropdown-item" href="{{url('/assemblymen', $parameters = [], $secure = null)}}">
                                        Parlamentar
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @endshield

                                @shield('legislatures.index')
                                <li>
                                    <a class="dropdown-item" href="{{url('/legislatures', $parameters = [], $secure = null)}}">
                                        Legislatura
                                    </a>
                                </li>
                                @endshield
                                @shield('parties.index')
                                <li>
                                    <a class="dropdown-item" href="{{url('/parties', $parameters = [], $secure = null)}}">
                                        Partidos
                                    </a>
                                </li>
                                @endshield
                                @shield('responsibilities.index')
                                <li>
                                    <a class="dropdown-item" href="{{url('/responsibilities', $parameters = [], $secure = null)}}">
                                        Responsabilidade
                                    </a>
                                </li>
                                @endshield
                                @shield('sectors.index')
                                <li>
                                    <a class="dropdown-item" href="{{url('/sectors', $parameters = [], $secure = null)}}">
                                        Setores
                                    </a>
                                </li>
                                @endshield
                            </ul>
                        </li>
                    @endif
                @endshield

                @shield(
                    'documents.index',
                    'adviceSituationDocuments.index',
                    'advicePublicationDocuments.index',
                    'documentModels.index',
                    'documentTypes.index',
                    'documentSituations.index',
                    'statusProcessingDocuments.index'
                )
                    @if(App::make("ModuleService")->isActive('Documentos'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    Documentos
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @shield('documents.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/documents', $parameters = [], $secure = null)}}">Documentos</a>
                                    </li>

                                <li><hr class="dropdown-divider"></li>
                                @endshield

                                @shield('adviceSituationDocuments.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/adviceSituationDocuments', $parameters = [], $secure = null)}}">
                                            Situação do parecer do documento
                                        </a>
                                    </li>
                                @endshield
                                @shield('advicePublicationDocuments.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/advicePublicationDocuments', $parameters = [], $secure = null)}}">
                                            Publicação do parecer do documento
                                        </a>
                                    </li>
                                @endshield
                                @shield('documentModels.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/documentModels', $parameters = [], $secure = null)}}">
                                            Modelos de documentos
                                        </a>
                                    </li>
                                @endshield
                                @shield('documentTypes.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/documentTypes', $parameters = [], $secure = null)}}">
                                            Tipos de documentos
                                        </a>
                                    </li>
                                @endshield
                                @shield('documentSituations.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/documentSituations', $parameters = [], $secure = null)}}">
                                            Situação do documentos
                                        </a>
                                    </li>
                                @endshield
                                @shield('statusProcessingDocuments.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/statusProcessingDocuments', $parameters = [], $secure = null)}}">
                                            Status do tramite
                                        </a>
                                    </li>
                                @endshield
                            </ul>
                        </li>
                    @endif
                @endshield

                @shield('commissions.index', 'officeCommissions.index', 'comissionSituations.index')
                    @if(App::make("ModuleService")->isActive('Comissoes'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    Comissões
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @shield('commissions.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/commissions', $parameters = [], $secure = null)}}">
                                            Comissões
                                        </a>
                                    </li>

                                <li><hr class="dropdown-divider"></li>
                                @endshield
                                @shield('officeCommissions.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/officeCommissions', $parameters = [], $secure = null)}}">
                                            Cargo de comissão
                                        </a>
                                    </li>
                                @endshield
                                @shield('comissionSituations.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/comissionSituations', $parameters = [], $secure = null)}}">
                                            Situação de comissão
                                        </a>
                                    </li>
                                @endshield
                            </ul>
                        </li>
                    @endif
                @endshield

                @shield('meetings.index', 'version_pauta.index', 'sessionTypes.index', 'structurepautas.index')
                    @if(App::make("ModuleService")->isActive('Sessoes'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    Sessões
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @shield('meetings.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/meetings', $parameters = [], $secure = null)}}">
                                            Sessões
                                        </a>
                                    </li>

                                <li><hr class="dropdown-divider"></li>
                                @endshield

                                @if(\Illuminate\Support\Facades\Auth::user()->sector->slug == 'gabinete')
                                    <li>
                                        @if(Auth::user()->assemblyman_count())
                                            <a class="dropdown-item" href="/voting/assemblyman/{{Auth::user()->get_assemblyman()}}">
                                                <i class="fa fa-list"></i> Votação
                                            </a>
                                        @else
                                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#select_gabinete">
                                                <i class="fa fa-list"></i> Votação
                                            </a>
                                        @endif
                                    </li>
                                @endif
                                @shield('version_pauta.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/version_pauta', $parameters = [], $secure = null)}}">
                                            Estrutura de Pauta
                                        </a>
                                    </li>
                                @endshield
                                @shield('sessionTypes.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/sessionTypes', $parameters = [], $secure = null)}}">
                                            Tipo de Sessões
                                        </a>
                                    </li>
                                @endshield
                                {{--@shield('structurepautas.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/structurepautas', $parameters = [], $secure = null)}}">
                                            Estrutura de Pauta
                                        </a>
                                    </li>
                                @endshield--}}
                                @shield('structurepautas.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/typeVotings', $parameters = [], $secure = null)}}">
                                            Tipo de votação
                                        </a>
                                    </li>
                                @endshield
                            </ul>
                        </li>
                    @endif
                @endshield

                @shield(
                    'lawsProjects.index',
                    'lawSituations.index',
                    'adviceSituationLaws.index',
                    'advicePublicationLaws.index',
                    'statusProcessingLaws.index',
                    'lawsTypes.index',
                    'lawsTags.index',
                    'lawsStructures.index',
                    'lawsPlaces.index'
                )
                    @if(App::make("ModuleService")->isActive('Leis'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    Projeto de Lei
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @shield('lawsProjects.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/lawsProjects', $parameters = [], $secure = null)}}">
                                            Projeto de lei
                                        </a>
                                    </li>

                                <li><hr class="dropdown-divider"></li>
                                @endshield

                                @shield('lawSituations.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/lawSituations', $parameters = [], $secure = null)}}">
                                            Situação de lei
                                        </a>
                                    </li>
                                @endshield
                                @shield('adviceSituationLaws.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/adviceSituationLaws', $parameters = [], $secure = null)}}">
                                            Situação do parecer da lei
                                        </a>
                                    </li>
                                @endshield
                                @shield('advicePublicationLaws.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/advicePublicationLaws', $parameters = [], $secure = null)}}">
                                            Publicação do parecer da lei
                                        </a>
                                    </li>
                                @endshield
                                @shield('statusProcessingLaws.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/statusProcessingLaws', $parameters = [], $secure = null)}}">
                                            Status do Tramite
                                        </a>
                                    </li>
                                @endshield
                                @shield('lawsTypes.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/lawsTypes', $parameters = [], $secure = null)}}">
                                            Tipos de lei
                                        </a>
                                    </li>
                                @endshield
                                @shield('lawsTags.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/lawsTags', $parameters = [], $secure = null)}}">
                                            Tags de lei
                                        </a>
                                    </li>
                                @endshield
                                @shield('lawsStructures.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/lawsStructures', $parameters = [], $secure = null)}}">
                                            Tipo de estruturas de lei
                                        </a>
                                    </li>
                                @endshield
                                @shield('lawsPlaces.index')
                                    <li>
                                        <a class="dropdown-item" href="{{url('/lawsPlaces', $parameters = [], $secure = null)}}">
                                            Local de publicação
                                        </a>
                                    </li>
                                @endshield
                            </ul>
                        </li>
                    @endif
                @endshield

                @shield('attendance.index', 'people.index', 'typesOfAttendance.index')
                    @if(App::make("ModuleService")->isActive('Attendance'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    Recepção
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @shield('attendance.index')
                                <li>
                                    <a class="dropdown-item" href="{{url('/attendance', $parameters = [], $secure = null)}}">
                                        Atendimento
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>
                                @endshield
                                @shield('people.index')
                                <li>
                                    <a class="dropdown-item" href="{{url('/people', $parameters = [], $secure = null)}}">
                                        Pessoas
                                    </a>
                                </li>
                                @endshield
                                @shield('typesOfAttendance.index')
                                <li>
                                    <a class="dropdown-item" href="{{url('/types-of-attendance', $parameters = [], $secure = null)}}">Tipo de Atendimento</a>
                                </li>
                                @endshield
                            </ul>
                        </li>
                    @endif
                @endshield


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>
                            Relatórios
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/report/documents">
                                Documentos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/report/documents/noFiles">
                                Documentos sem arquivos
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="/report/lawsProject">
                                Projetos de lei
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/report/lawsProject/noFiles">
                                Projeto de lei sem arquivos
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="/report/meeting/noFiles">
                                Pautas/ATA sem arquivos
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="/report/getTramitacao">
                                Projetos de lei / Tramitacao
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://www.genesis.tec.br/">
                        Ajuda
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
