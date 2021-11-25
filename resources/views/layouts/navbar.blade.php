<style>
    .space {
        margin-right: 0.5rem;
    }
    .courser {
        cursor: pointer;
    }
</style>

<ul class="nav navbar-nav">
    @is(['root'])
        <li class="dropdown">
            <a class="dropdown-toggle courser" data-toggle="dropdown">
                <span>
                    Configurações
                </span>
            </a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @is('root')
                    @shield('modules.index')
                        <li>
                            <a href="{{url('/config/modules', $parameters = [], $secure = null)}}">
                                <i class="fa fa-cubes space"></i>Módulos
                            </a>
                        </li>
                    @endshield
                    @shield('permissions.index')
                        <li>
                            <a href="{{url('/config/permissions', $parameters = [], $secure = null)}}">
                                <i class="fa fa-key space"></i>Permissões
                            </a>
                        </li>
                    @endshield
                    @shield('parameters.index')
                        <li>
                            <a href="{{url('/config/parameters', $parameters = [], $secure = null)}}">
                                <i class="fa fa-sliders space"></i>Parâmetros
                            </a>
                        </li>
                    @endshield
                    @shield('documents.importNumber')
                        <li>
                            <a href="{{url('/config/importNumber', $parameters = [], $secure = null)}}">
                                <i class="fa fa-file space"></i>Migrar número de documento
                            </a>
                        </li>
                    @endshield
                    @shield('lawsProjects.importNumberLaw')
                        <li>
                            <a href="{{url('/config/importNumberLaw', $parameters = [], $secure = null)}}">
                                <i class="fa fa-gavel space"></i>Migrar número da lei
                            </a>
                        </li>
                    @endshield
                @endis
            </ul>
        </li>
    @endis

    @if(App::make("ModuleService")->isActive('Geral'))
        <li>
            <a class="dropdown-toggle courser" data-toggle="dropdown"><span>Geral</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @is(['root','admin'])
                    <li>
                        <a href="{{url('/config/companies', $parameters = [], $secure = null)}}">
                            <i class="fa fa-bank space"></i>Instituição
                        </a>
                    </li>
                @endis
                @shield('users.index')
                    <li>
                        <a href="{{url('/users', $parameters = [], $secure = null)}}">
                            <i class="fa fa-users space"></i>Usuarios
                        </a>
                    </li>
                @endshield

                <li class="divider"></li>

                @is(['root','admin'])
                    <li>
                        <a href="{{url('/importer/sgl', $parameters = [], $secure = null)}}">
                            <i class="fa fa-upload space"></i>Importador de documentos
                        </a>
                    </li>
                @endis
                @is(['root','admin'])
                    <li>
                        <a href="{{url('/importer/projects', $parameters = [], $secure = null)}}">
                            <i class="fa fa-upload space"></i>Importador de projetos de lei
                        </a>
                    </li>
                @endis

                <li class="divider"></li>

                @shield('roles.index')
                    <li>
                        <a href="{{url('/gerencial/roles', $parameters = [], $secure = null)}}">
                            <i class="fa fa-cog space"></i>Grupos de Permissões
                        </a>
                    </li>
                @endshield
                @is(['root','admin'])
                    <li>
                        <a href="{{url('/logs', $parameters = [], $secure = null)}}">
                            <i class="fa fa-cog space"></i>Auditoria
                        </a>
                    </li>
                @endis

                <li class="divider"></li>

                @is(['root','admin'])
                    <li>
                        <a href="{{url('/config/export/files', $parameters = [], $secure = null)}}">
                            <i class="fa fa-cog space"></i>Exportar Documentos
                        </a>
                    </li>
                @endshield
            </ul>
        </li>
    @endif

    @if(App::make("ModuleService")->isActive('Cadastro'))
        <li>
            <a class="dropdown-toggle courser" data-toggle="dropdown"><span>Cadastro</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('assemblymen.index')
                    <li>
                        <a href="{{url('/assemblymen', $parameters = [], $secure = null)}}">
                            Parlamentar
                        </a>
                    </li>
                @endshield

                <li class="divider"></li>

                @shield('legislatures.index')
                    <li>
                        <a href="{{url('/legislatures', $parameters = [], $secure = null)}}">
                            Legislatura
                        </a>
                    </li>
                @endshield
                @shield('parties.index')
                    <li>
                        <a href="{{url('/parties', $parameters = [], $secure = null)}}">
                            Partidos
                        </a>
                    </li>
                @endshield
                @shield('responsibilities.index')
                    <li>
                        <a href="{{url('/responsibilities', $parameters = [], $secure = null)}}">
                            Responsabilidade
                        </a>
                    </li>
                @endshield
                @shield('sectors.index')
                    <li>
                        <a href="{{url('/sectors', $parameters = [], $secure = null)}}">
                            Setores
                        </a>
                    </li>
                @endshield
            </ul>
        </li>
    @endif

    @if(App::make("ModuleService")->isActive('Documentos'))
        <li>
            <a class="dropdown-toggle courser" data-toggle="dropdown"><span>Documentos</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('documents.index')
                    <li>
                        <a href="{{url('/documents', $parameters = [], $secure = null)}}">Documentos</a>
                    </li>
                @endshield

                <li class="divider"></li>

                @shield('adviceSituationDocuments.index')
                    <li>
                        <a href="{{url('/adviceSituationDocuments', $parameters = [], $secure = null)}}">
                            Situação do parecer do documento
                        </a>
                    </li>
                @endshield
                @shield('advicePublicationDocuments.index')
                    <li>
                        <a href="{{url('/advicePublicationDocuments', $parameters = [], $secure = null)}}">
                            Publicação do parecer do documento
                        </a>
                    </li>
                @endshield
                @shield('documentModels.index')
                    <li>
                        <a href="{{url('/documentModels', $parameters = [], $secure = null)}}">
                            Modelos de documentos
                        </a>
                    </li>
                @endshield
                @shield('documentTypes.index')
                    <li>
                        <a href="{{url('/documentTypes', $parameters = [], $secure = null)}}">
                            Tipos de documentos
                        </a>
                    </li>
                @endshield
                @shield('documentSituations.index')
                    <li>
                        <a href="{{url('/documentSituations', $parameters = [], $secure = null)}}">
                            Situação do documentos
                        </a>
                    </li>
                @endshield
                @shield('statusProcessingDocuments.index')
                    <li>
                        <a href="{{url('/statusProcessingDocuments', $parameters = [], $secure = null)}}">
                            Status do tramite
                        </a>
                    </li>
                @endshield
            </ul>
        </li>
    @endif

    @if(App::make("ModuleService")->isActive('Comissoes'))
        <li>
            <a class="dropdown-toggle courser" data-toggle="dropdown"><span>Comissões</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('commissions.index')
                    <li>
                        <a href="{{url('/commissions', $parameters = [], $secure = null)}}">
                            Comissões
                        </a>
                    </li>
                @endshield

                <li class="divider"></li>

                @shield('officeCommissions.index')
                    <li>
                        <a href="{{url('/officeCommissions', $parameters = [], $secure = null)}}">
                            Cargo de comissão
                        </a>
                    </li>
                @endshield
                @shield('comissionSituations.index')
                    <li>
                        <a href="{{url('/comissionSituations', $parameters = [], $secure = null)}}">
                            Situações de pareceres
                        </a>
                    </li>
                @endshield
            </ul>
        </li>
    @endif

    @if(App::make("ModuleService")->isActive('Sessoes'))
        <li>
            <a class="dropdown-toggle courser" data-toggle="dropdown"><span>Sessões</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('meetings.index')
                    <li>
                        <a href="{{url('/meetings', $parameters = [], $secure = null)}}">
                            Sessões
                        </a>
                    </li>
                @endshield

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
                @shield('version_pauta.index')
                    <li>
                        <a href="{{url('/version_pauta', $parameters = [], $secure = null)}}">
                            Estrutura de Pauta
                        </a>
                    </li>
                @endshield
                @shield('sessionTypes.index')
                    <li>
                        <a href="{{url('/sessionTypes', $parameters = [], $secure = null)}}">
                            Tipo de Sessões
                        </a>
                    </li>
                @endshield
                {{--@shield('structurepautas.index')
                    <li>
                        <a href="{{url('/structurepautas', $parameters = [], $secure = null)}}">
                            Estrutura de Pauta
                        </a>
                    </li>
                @endshield--}}
                @shield('structurepautas.index')
                    <li>
                        <a href="{{url('/typeVotings', $parameters = [], $secure = null)}}">
                            Tipo de votação
                        </a>
                    </li>
                @endshield

            </ul>
        </li>
    @endif

    @if(App::make("ModuleService")->isActive('Leis'))
        <li>
            <a class="dropdown-toggle courser" data-toggle="dropdown"><span>Projeto de Lei</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('lawsProjects.index')
                    <li>
                        <a href="{{url('/lawsProjects', $parameters = [], $secure = null)}}">
                            Projeto de lei
                        </a>
                    </li>
                @endshield

                <li class="divider"></li>

                @shield('lawSituations.index')
                    <li>
                        <a href="{{url('/lawSituations', $parameters = [], $secure = null)}}">
                            Situação de lei
                        </a>
                    </li>
                @endshield
                @shield('adviceSituationLaws.index')
                    <li>
                        <a href="{{url('/adviceSituationLaws', $parameters = [], $secure = null)}}">
                            Situação do parecer da lei
                        </a>
                    </li>
                @endshield
                @shield('advicePublicationLaws.index')
                    <li>
                        <a href="{{url('/advicePublicationLaws', $parameters = [], $secure = null)}}">
                            Publicação do parecer da lei
                        </a>
                    </li>
                @endshield
                @shield('statusProcessingLaws.index')
                    <li>
                        <a href="{{url('/statusProcessingLaws', $parameters = [], $secure = null)}}">
                            Status do Tramite
                        </a>
                    </li>
                @endshield
                @shield('lawsTypes.index')
                    <li>
                        <a href="{{url('/lawsTypes', $parameters = [], $secure = null)}}">
                            Tipos de lei
                        </a>
                    </li>
                @endshield
                @shield('lawsTags.index')
                    <li>
                        <a href="{{url('/lawsTags', $parameters = [], $secure = null)}}">
                            Tags de lei
                        </a>
                    </li>
                @endshield
                @shield('lawsStructures.index')
                    <li>
                        <a href="{{url('/lawsStructures', $parameters = [], $secure = null)}}">
                            Tipo de estruturas de lei
                        </a>
                    </li>
                @endshield
                @shield('lawsPlaces.index')
                    <li>
                        <a href="{{url('/lawsPlaces', $parameters = [], $secure = null)}}">
                            Locais publicação
                        </a>
                    </li>
                @endshield
            </ul>
        </li>
    @endif

    @if(App::make("ModuleService")->isActive('Attendance'))
        <li>
            <a class="dropdown-toggle courser" data-toggle="dropdown"><span>Recepção</span></a>
            <ul class="dropdown-menu square margin-list-rounded with-triangle">
                @shield('attendance.index')
                    <li>
                        <a href="{{url('/attendance', $parameters = [], $secure = null)}}">
                            Atendimento
                        </a>
                    </li>
                @endshield

                <li class="divider"></li>

                @shield('people.index')
                    <li>
                        <a href="{{url('/people', $parameters = [], $secure = null)}}">
                            Pessoas
                        </a>
                    </li>
                @endshield
                @shield('typesOfAttendance.index')
                    <li>
                        <a href="{{url('/types-of-attendance', $parameters = [], $secure = null)}}">
                            Tipo de Atendimento
                        </a>
                    </li>
                @endshield
            </ul>
        </li>
    @endif

    <li>
        <a class="dropdown-toggle courser" data-toggle="dropdown">Relatórios</a>
        <ul class="dropdown-menu square margin-list-rounded with-triangle">
            <li>
                <a href="/report/documents">
                    Documentos
                </a>
            </li>
            <li>
                <a href="/report/documents/noFiles">
                    Documentos sem arquivos
                </a>
            </li>

            <li class="divider"></li>

            <li>
                <a href="/report/lawsProject">
                    Projetos de lei
                </a>
            </li>
            <li>
                <a href="/report/lawsProject/noFiles">
                    Projeto de lei sem arquivos
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="/report/meeting/noFiles">
                    Pautas/ATA sem arquivos
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="/report/getTramitacao">
                    Projetos de lei / Tramitacao
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="https://www.genesis.tec.br/" target="_blank">
            Ajuda
        </a>
    </li>
</ul>
