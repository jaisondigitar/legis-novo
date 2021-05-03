<?php

use Illuminate\Database\Seeder;
use Artesaos\Defender\Facades\Defender;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
         * GRUPOS DE PERMISSOES PADRÃO
         */
        $roleRoot       = Defender::roleExists('root') ? Defender::findRole('root') : Defender::createRole('root');
        $roleAdmin      = Defender::roleExists('admin') ? Defender::findRole('admin') : Defender::createRole('admin');
        $roleUser       = Defender::roleExists('user') ? Defender::findRole('user') : Defender::createRole('user');

        $roleApprovedDocument       = Defender::roleExists('Aprovação documento') ? Defender::findRole('Aprovação documento') : Defender::createRole('Aprovação documento');
        $roleReadDocument           = Defender::roleExists('Leitura documento') ? Defender::findRole('Leitura documento') : Defender::createRole('Leitura documento');

        $roleApprovedLawsProject       = Defender::roleExists('Aprovação projeto de lei') ? Defender::findRole('Aprovação projeto de lei') : Defender::createRole('Aprovação projeto de lei');
        $roleReadLawsProject           = Defender::roleExists('Leitura projeto de lei') ? Defender::findRole('Leitura projeto de lei') : Defender::createRole('Leitura projeto de lei');

        $rolePodePedirParecer          = Defender::roleExists('Solicita parecer') ? Defender::findRole('Solicita parecer') : Defender::createRole('Solicita parecer');

        /*
         *  PERMISSOES ROOT
         */
        $perm['root'][] = Defender::permissionExists('companies.create') ? Defender::findPermission('companies.create')  : Defender::createPermission('companies.create', 'Criar empresa');
        $perm['root'][] = Defender::permissionExists('companies.index')  ? Defender::findPermission('companies.index')   : Defender::createPermission('companies.index','Ver empresas');
        $perm['root'][] = Defender::permissionExists('companies.edit')   ? Defender::findPermission('companies.edit')    : Defender::createPermission('companies.edit','Editar empresa');
        $perm['root'][] = Defender::permissionExists('companies.delete') ? Defender::findPermission('companies.delete')  : Defender::createPermission('companies.delete','Excluir empresa');
        $perm['root'][] = Defender::permissionExists('companies.show')   ? Defender::findPermission('companies.show')    : Defender::createPermission('companies.show','Detalhe da empresa');

        $perm['root'][] = Defender::permissionExists('modules.create') ? Defender::findPermission('modules.create')  : Defender::createPermission('modules.create', 'Criar modulo');
        $perm['root'][] = Defender::permissionExists('modules.index')  ? Defender::findPermission('modules.index')   : Defender::createPermission('modules.index','Ver modulos');
        $perm['root'][] = Defender::permissionExists('modules.edit')   ? Defender::findPermission('modules.edit')    : Defender::createPermission('modules.edit','Editar modulo');
        $perm['root'][] = Defender::permissionExists('modules.delete') ? Defender::findPermission('modules.delete')  : Defender::createPermission('modules.delete','Excluir modulo');
        $perm['root'][] = Defender::permissionExists('modules.show')   ? Defender::findPermission('modules.show')    : Defender::createPermission('modules.show','Detalhe da modulo');

        $perm['root'][] = Defender::permissionExists('permissions.create') ? Defender::findPermission('permissions.create')  : Defender::createPermission('permissions.create', 'Criar permissão');
        $perm['root'][] = Defender::permissionExists('permissions.index')  ? Defender::findPermission('permissions.index')   : Defender::createPermission('permissions.index','Ver permissões');
        $perm['root'][] = Defender::permissionExists('permissions.edit')   ? Defender::findPermission('permissions.edit')    : Defender::createPermission('permissions.edit','Editar permissão');
        $perm['root'][] = Defender::permissionExists('permissions.delete') ? Defender::findPermission('permissions.delete')  : Defender::createPermission('permissions.delete','Excluir permissão');
        $perm['root'][] = Defender::permissionExists('permissions.show')   ? Defender::findPermission('permissions.show')    : Defender::createPermission('permissions.show','Detalhe da permissão');

        $perm['root'][] = Defender::permissionExists('parameters.create') ? Defender::findPermission('parameters.create')  :  Defender::createPermission('parameters.create','Criar parâmetro');
        $perm['root'][] = Defender::permissionExists('parameters.index') ? Defender::findPermission('parameters.index')  :  Defender::createPermission('parameters.index','Ver parâmetro');
        $perm['root'][] = Defender::permissionExists('parameters.edit') ? Defender::findPermission('parameters.edit')  :  Defender::createPermission('parameters.edit','Editar parâmetro');
        $perm['root'][] = Defender::permissionExists('parameters.delete') ? Defender::findPermission('parameters.delete')  :  Defender::createPermission('parameters.delete','Excluir parâmetro');
        $perm['root'][] = Defender::permissionExists('parameters.show') ? Defender::findPermission('parameters.show')  :  Defender::createPermission('parameters.show','Detalhe parâmetro');

        $perm['root'][] = Defender::permissionExists('documents.importNumber') ? Defender::findPermission('documents.importNumber')  :  Defender::createPermission('documents.importNumber','Migrar numero do documento');
        $perm['root'][] = Defender::permissionExists('lawsProjects.importNumberLaw') ? Defender::findPermission('lawsProjects.importNumberLaw')  :  Defender::createPermission('lawsProjects.importNumberLaw','Migrar numero da lei');

        /*
         *  PERMISSOES ADMIN
         */
        $perm['company'][] = Defender::permissionExists('roles.create') ? Defender::findPermission('roles.create')  :  Defender::createPermission('roles.create','Criar regras');
        $perm['company'][] = Defender::permissionExists('roles.index') ? Defender::findPermission('roles.index')  :  Defender::createPermission('roles.index','Ver regras');
        $perm['company'][] = Defender::permissionExists('roles.edit') ? Defender::findPermission('roles.edit')  :  Defender::createPermission('roles.edit','Editar regras');
        $perm['company'][] = Defender::permissionExists('roles.delete') ? Defender::findPermission('roles.delete')  :  Defender::createPermission('roles.delete','Excluir regras');
        $perm['company'][] = Defender::permissionExists('roles.show') ? Defender::findPermission('roles.show')  :  Defender::createPermission('roles.show','Detalhe da regras');

        $perm['company'][] = Defender::permissionExists('logs.create') ? Defender::findPermission('logs.create')  :  Defender::createPermission('logs.create','Criar logs');
        $perm['company'][] = Defender::permissionExists('logs.index') ? Defender::findPermission('logs.index')  :  Defender::createPermission('logs.index','Ver logs');
        $perm['company'][] = Defender::permissionExists('logs.edit') ? Defender::findPermission('logs.edit')  :  Defender::createPermission('logs.edit','Editar logs');
        $perm['company'][] = Defender::permissionExists('logs.delete') ? Defender::findPermission('logs.delete')  :  Defender::createPermission('logs.delete','Excluir logs');
        $perm['company'][] = Defender::permissionExists('logs.show') ? Defender::findPermission('logs.show')  :  Defender::createPermission('logs.show','Detalhe da logs');

        $perm['company'][] = Defender::permissionExists('users.create') ? Defender::findPermission('users.create')  :  Defender::createPermission('users.create','Criar usuario');
        $perm['company'][] = Defender::permissionExists('users.index') ? Defender::findPermission('users.index')  :  Defender::createPermission('users.index','Ver usuarios');
        $perm['company'][] = Defender::permissionExists('users.edit') ? Defender::findPermission('users.edit')  :  Defender::createPermission('users.edit','Editar usuario');
        $perm['company'][] = Defender::permissionExists('users.delete') ? Defender::findPermission('users.delete')  :  Defender::createPermission('users.delete','Excluir usuario');
        $perm['company'][] = Defender::permissionExists('users.show') ? Defender::findPermission('users.show')  :  Defender::createPermission('users.show','Detalhe da usuario');

        $perm['company'][] = Defender::permissionExists('legislatures.create') ? Defender::findPermission('legislatures.create')  :  Defender::createPermission('legislatures.create','Criar legislatura');
        $perm['company'][] = Defender::permissionExists('legislatures.index') ? Defender::findPermission('legislatures.index')  :  Defender::createPermission('legislatures.index','Ver legislaturas');
        $perm['company'][] = Defender::permissionExists('legislatures.edit') ? Defender::findPermission('legislatures.edit')  :  Defender::createPermission('legislatures.edit','Editar legislatura');
        $perm['company'][] = Defender::permissionExists('legislatures.delete') ? Defender::findPermission('legislatures.delete')  :  Defender::createPermission('legislatures.delete','Excluir legislatura');
        $perm['company'][] = Defender::permissionExists('legislatures.show') ? Defender::findPermission('legislatures.show')  :  Defender::createPermission('legislatures.show','Detalhe da legislatura');

        $perm['company'][] = Defender::permissionExists('parties.create') ? Defender::findPermission('parties.create')  :  Defender::createPermission('parties.create','Criar partido');
        $perm['company'][] = Defender::permissionExists('parties.index') ? Defender::findPermission('parties.index')  :  Defender::createPermission('parties.index','Ver partidos');
        $perm['company'][] = Defender::permissionExists('parties.edit') ? Defender::findPermission('parties.edit')  :  Defender::createPermission('parties.edit','Editar partido');
        $perm['company'][] = Defender::permissionExists('parties.delete') ? Defender::findPermission('parties.delete')  :  Defender::createPermission('parties.delete','Excluir partido');
        $perm['company'][] = Defender::permissionExists('parties.show') ? Defender::findPermission('parties.show')  :  Defender::createPermission('parties.show','Detalhe da partido');

        $perm['company'][] = Defender::permissionExists('responsibilities.create') ? Defender::findPermission('responsibilities.create')  :  Defender::createPermission('responsibilities.create','Criar responsabilidade');
        $perm['company'][] = Defender::permissionExists('responsibilities.index') ? Defender::findPermission('responsibilities.index')  :  Defender::createPermission('responsibilities.index','Ver responsabilidades');
        $perm['company'][] = Defender::permissionExists('responsibilities.edit') ? Defender::findPermission('responsibilities.edit')  :  Defender::createPermission('responsibilities.edit','Editar responsabilidade');
        $perm['company'][] = Defender::permissionExists('responsibilities.delete') ? Defender::findPermission('responsibilities.delete')  :  Defender::createPermission('responsibilities.delete','Excluir responsabilidade');
        $perm['company'][] = Defender::permissionExists('responsibilities.show') ? Defender::findPermission('responsibilities.show')  :  Defender::createPermission('responsibilities.show','Detalhe da responsabilidade');

        $perm['company'][] = Defender::permissionExists('assemblymen.create') ? Defender::findPermission('assemblymen.create')  :  Defender::createPermission('assemblymen.create','Criar vereador');
        $perm['company'][] = Defender::permissionExists('assemblymen.index') ? Defender::findPermission('assemblymen.index')  :  Defender::createPermission('assemblymen.index','Ver vereadores');
        $perm['company'][] = Defender::permissionExists('assemblymen.edit') ? Defender::findPermission('assemblymen.edit')  :  Defender::createPermission('assemblymen.edit','Editar vereador');
        $perm['company'][] = Defender::permissionExists('assemblymen.delete') ? Defender::findPermission('assemblymen.delete')  :  Defender::createPermission('assemblymen.delete','Excluir vereador');
        $perm['company'][] = Defender::permissionExists('assemblymen.show') ? Defender::findPermission('assemblymen.show')  :  Defender::createPermission('assemblymen.show','Detalhe da vereador');

        $perm['company'][] = Defender::permissionExists('sectors.create') ? Defender::findPermission('sectors.create')  :  Defender::createPermission('sectors.create','Criar setores');
        $perm['company'][] = Defender::permissionExists('sectors.index') ? Defender::findPermission('sectors.index')  :  Defender::createPermission('sectors.index','Ver setores');
        $perm['company'][] = Defender::permissionExists('sectors.edit') ? Defender::findPermission('sectors.edit')  :  Defender::createPermission('sectors.edit','Editar setor');
        $perm['company'][] = Defender::permissionExists('sectors.delete') ? Defender::findPermission('sectors.delete')  :  Defender::createPermission('sectors.delete','Excluir setor');
        $perm['company'][] = Defender::permissionExists('sectors.show') ? Defender::findPermission('sectors.show')  :  Defender::createPermission('sectors.show','Detalhe da setor');

        $perm['company'][] = Defender::permissionExists('documentTypes.create') ? Defender::findPermission('documentTypes.create')  :  Defender::createPermission('documentTypes.create','Criar tipo de documentos');
        $perm['company'][] = Defender::permissionExists('documentTypes.index') ? Defender::findPermission('documentTypes.index')  :  Defender::createPermission('documentTypes.index','Ver tipos de documentos');
        $perm['company'][] = Defender::permissionExists('documentTypes.edit') ? Defender::findPermission('documentTypes.edit')  :  Defender::createPermission('documentTypes.edit','Editar tipo de documentos');
        $perm['company'][] = Defender::permissionExists('documentTypes.delete') ? Defender::findPermission('documentTypes.delete')  :  Defender::createPermission('documentTypes.delete','Excluir tipo de documentos');
        $perm['company'][] = Defender::permissionExists('documentTypes.show') ? Defender::findPermission('documentTypes.show')  :  Defender::createPermission('documentTypes.show','Detalhe tipo de documentos');

        $perm['company'][] = Defender::permissionExists('documentModels.create') ? Defender::findPermission('documentModels.create')  :  Defender::createPermission('documentModels.create','Criar modelo de documentos');
        $perm['company'][] = Defender::permissionExists('documentModels.index') ? Defender::findPermission('documentModels.index')  :  Defender::createPermission('documentModels.index','Ver modelos de documentos');
        $perm['company'][] = Defender::permissionExists('documentModels.edit') ? Defender::findPermission('documentModels.edit')  :  Defender::createPermission('documentModels.edit','Editar modelo de documentos');
        $perm['company'][] = Defender::permissionExists('documentModels.delete') ? Defender::findPermission('documentModels.delete')  :  Defender::createPermission('documentModels.delete','Excluir modelo de documentos');
        $perm['company'][] = Defender::permissionExists('documentModels.show') ? Defender::findPermission('documentModels.show')  :  Defender::createPermission('documentModels.show','Detalhe modelo de documentos');

        $perm['company'][] = Defender::permissionExists('documentSituations.create') ? Defender::findPermission('documentSituations.create')  :  Defender::createPermission('documentSituations.create','Criar situação de documentos');
        $perm['company'][] = Defender::permissionExists('documentSituations.index') ? Defender::findPermission('documentSituations.index')  :  Defender::createPermission('documentSituations.index','Ver situação de documentos');
        $perm['company'][] = Defender::permissionExists('documentSituations.edit') ? Defender::findPermission('documentSituations.edit')  :  Defender::createPermission('documentSituations.edit','Editar situação de documentos');
        $perm['company'][] = Defender::permissionExists('documentSituations.delete') ? Defender::findPermission('documentSituations.delete')  :  Defender::createPermission('documentSituations.delete','Excluir situação de documentos');
        $perm['company'][] = Defender::permissionExists('documentSituations.show') ? Defender::findPermission('documentSituations.show')  :  Defender::createPermission('documentSituations.show','Detalhe situação de documentos');

        $perm['company'][] = Defender::permissionExists('protocolTypes.create') ? Defender::findPermission('protocolTypes.create')  :  Defender::createPermission('protocolTypes.create','Criar tipo de protocolo');
        $perm['company'][] = Defender::permissionExists('protocolTypes.index') ? Defender::findPermission('protocolTypes.index')  :  Defender::createPermission('protocolTypes.index','Ver tipos de protocolos');
        $perm['company'][] = Defender::permissionExists('protocolTypes.edit') ? Defender::findPermission('protocolTypes.edit')  :  Defender::createPermission('protocolTypes.edit','Editar tipo de protocolo');
        $perm['company'][] = Defender::permissionExists('protocolTypes.delete') ? Defender::findPermission('protocolTypes.delete')  :  Defender::createPermission('protocolTypes.delete','Excluir tipo de protocolo');
        $perm['company'][] = Defender::permissionExists('protocolTypes.show') ? Defender::findPermission('protocolTypes.show')  :  Defender::createPermission('protocolTypes.show','Detalhe tipo de protocolo');

        $perm['company'][] = Defender::permissionExists('documents.create') ? Defender::findPermission('documents.create')  :  Defender::createPermission('documents.create','Criar documento');
        $perm['company'][] = Defender::permissionExists('documents.index') ? Defender::findPermission('documents.index')  :  Defender::createPermission('documents.index','Ver documento');
        $perm['company'][] = Defender::permissionExists('documents.edit') ? Defender::findPermission('documents.edit')  :  Defender::createPermission('documents.edit','Editar documento');
        $perm['company'][] = Defender::permissionExists('documents.delete') ? Defender::findPermission('documents.delete')  :  Defender::createPermission('documents.delete','Excluir documento');
        $perm['company'][] = Defender::permissionExists('documents.show') ? Defender::findPermission('documents.show')  :  Defender::createPermission('documents.show','Detalhe documento');

        $perm['company'][] = Defender::permissionExists('commissions.create') ? Defender::findPermission('commissions.create')  :  Defender::createPermission('commissions.create','Criar comissão');
        $perm['company'][] = Defender::permissionExists('commissions.index') ? Defender::findPermission('commissions.index')  :  Defender::createPermission('commissions.index','Ver comissão');
        $perm['company'][] = Defender::permissionExists('commissions.edit') ? Defender::findPermission('commissions.edit')  :  Defender::createPermission('commissions.edit','Editar comissão');
        $perm['company'][] = Defender::permissionExists('commissions.delete') ? Defender::findPermission('commissions.delete')  :  Defender::createPermission('commissions.delete','Excluir comissão');
        $perm['company'][] = Defender::permissionExists('commissions.show') ? Defender::findPermission('commissions.show')  :  Defender::createPermission('commissions.show','Detalhe comissão');

        $perm['company'][] = Defender::permissionExists('officeCommissions.create') ? Defender::findPermission('officeCommissions.create')  :  Defender::createPermission('officeCommissions.create','Criar cargo de comissão');
        $perm['company'][] = Defender::permissionExists('officeCommissions.index') ? Defender::findPermission('officeCommissions.index')  :  Defender::createPermission('officeCommissions.index','Ver cargo de comissão');
        $perm['company'][] = Defender::permissionExists('officeCommissions.edit') ? Defender::findPermission('officeCommissions.edit')  :  Defender::createPermission('officeCommissions.edit','Editar cargo de comissão');
        $perm['company'][] = Defender::permissionExists('officeCommissions.delete') ? Defender::findPermission('officeCommissions.delete')  :  Defender::createPermission('officeCommissions.delete','Excluir cargo de comissão');
        $perm['company'][] = Defender::permissionExists('officeCommissions.show') ? Defender::findPermission('officeCommissions.show')  :  Defender::createPermission('officeCommissions.show','Detalhe cargo de comissão');

        $perm['company'][] = Defender::permissionExists('sessionTypes.create') ? Defender::findPermission('sessionTypes.create')  :  Defender::createPermission('sessionTypes.create','Criar tipo de sessão');
        $perm['company'][] = Defender::permissionExists('sessionTypes.index') ? Defender::findPermission('sessionTypes.index')  :  Defender::createPermission('sessionTypes.index','Ver tipo de sessão');
        $perm['company'][] = Defender::permissionExists('sessionTypes.edit') ? Defender::findPermission('sessionTypes.edit')  :  Defender::createPermission('sessionTypes.edit','Editar tipo de sessão');
        $perm['company'][] = Defender::permissionExists('sessionTypes.delete') ? Defender::findPermission('sessionTypes.delete')  :  Defender::createPermission('sessionTypes.delete','Excluir tipo de sessão');
        $perm['company'][] = Defender::permissionExists('sessionTypes.show') ? Defender::findPermission('sessionTypes.show')  :  Defender::createPermission('sessionTypes.show','Detalhe tipo de sessão');

        $perm['company'][] = Defender::permissionExists('sessionPlaces.create') ? Defender::findPermission('sessionPlaces.create')  :  Defender::createPermission('sessionPlaces.create','Criar local de sessão');
        $perm['company'][] = Defender::permissionExists('sessionPlaces.index') ? Defender::findPermission('sessionPlaces.index')  :  Defender::createPermission('sessionPlaces.index','Ver local de sessão');
        $perm['company'][] = Defender::permissionExists('sessionPlaces.edit') ? Defender::findPermission('sessionPlaces.edit')  :  Defender::createPermission('sessionPlaces.edit','Editar local de sessão');
        $perm['company'][] = Defender::permissionExists('sessionPlaces.delete') ? Defender::findPermission('sessionPlaces.delete')  :  Defender::createPermission('sessionPlaces.delete','Excluir local de sessão');
        $perm['company'][] = Defender::permissionExists('sessionPlaces.show') ? Defender::findPermission('sessionPlaces.show')  :  Defender::createPermission('sessionPlaces.show','Detalhe local de sessão');

        $perm['company'][] = Defender::permissionExists('meetings.create') ? Defender::findPermission('meetings.create')  :  Defender::createPermission('meetings.create','Criar sessão');
        $perm['company'][] = Defender::permissionExists('meetings.index') ? Defender::findPermission('meetings.index')  :  Defender::createPermission('meetings.index','Ver sessão');
        $perm['company'][] = Defender::permissionExists('meetings.edit') ? Defender::findPermission('meetings.edit')  :  Defender::createPermission('meetings.edit','Editar sessão');
        $perm['company'][] = Defender::permissionExists('meetings.delete') ? Defender::findPermission('meetings.delete')  :  Defender::createPermission('meetings.delete','Excluir sessão');
        $perm['company'][] = Defender::permissionExists('meetings.show') ? Defender::findPermission('meetings.show')  :  Defender::createPermission('meetings.show','Detalhe sessão');

        $perm['company'][] = Defender::permissionExists('lawsTypes.create') ? Defender::findPermission('lawsTypes.create')  :  Defender::createPermission('lawsTypes.create','Criar tipo de lei');
        $perm['company'][] = Defender::permissionExists('lawsTypes.index') ? Defender::findPermission('lawsTypes.index')  :  Defender::createPermission('lawsTypes.index','Ver tipo de lei');
        $perm['company'][] = Defender::permissionExists('lawsTypes.edit') ? Defender::findPermission('lawsTypes.edit')  :  Defender::createPermission('lawsTypes.edit','Editar tipo de lei');
        $perm['company'][] = Defender::permissionExists('lawsTypes.delete') ? Defender::findPermission('lawsTypes.delete')  :  Defender::createPermission('lawsTypes.delete','Excluir tipo de lei');
        $perm['company'][] = Defender::permissionExists('lawsTypes.show') ? Defender::findPermission('lawsTypes.show')  :  Defender::createPermission('lawsTypes.show','Detalhe tipo de lei');

        $perm['company'][] = Defender::permissionExists('lawsPlaces.create') ? Defender::findPermission('lawsPlaces.create')  :  Defender::createPermission('lawsPlaces.create','Criar local de publicação');
        $perm['company'][] = Defender::permissionExists('lawsPlaces.index') ? Defender::findPermission('lawsPlaces.index')  :  Defender::createPermission('lawsPlaces.index','Ver local de publicação');
        $perm['company'][] = Defender::permissionExists('lawsPlaces.edit') ? Defender::findPermission('lawsPlaces.edit')  :  Defender::createPermission('lawsPlaces.edit','Editar local de publicação');
        $perm['company'][] = Defender::permissionExists('lawsPlaces.delete') ? Defender::findPermission('lawsPlaces.delete')  :  Defender::createPermission('lawsPlaces.delete','Excluir local de publicação');
        $perm['company'][] = Defender::permissionExists('lawsPlaces.show') ? Defender::findPermission('lawsPlaces.show')  :  Defender::createPermission('lawsPlaces.show','Detalhe local de publicação');

        $perm['company'][] = Defender::permissionExists('lawsStructures.create') ? Defender::findPermission('lawsStructures.create')  :  Defender::createPermission('lawsStructures.create','Criar tipo de estrutura');
        $perm['company'][] = Defender::permissionExists('lawsStructures.index') ? Defender::findPermission('lawsStructures.index')  :  Defender::createPermission('lawsStructures.index','Ver tipo de estrutura');
        $perm['company'][] = Defender::permissionExists('lawsStructures.edit') ? Defender::findPermission('lawsStructures.edit')  :  Defender::createPermission('lawsStructures.edit','Editar tipo de estrutura');
        $perm['company'][] = Defender::permissionExists('lawsStructures.delete') ? Defender::findPermission('lawsStructures.delete')  :  Defender::createPermission('lawsStructures.delete','Excluir tipo de estrutura');
        $perm['company'][] = Defender::permissionExists('lawsStructures.show') ? Defender::findPermission('lawsStructures.show')  :  Defender::createPermission('lawsStructures.show','Detalhe tipo de estrutura');

        $perm['company'][] = Defender::permissionExists('lawsTags.create') ? Defender::findPermission('lawsTags.create')  :  Defender::createPermission('lawsTags.create','Criar tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsTags.index') ? Defender::findPermission('lawsTags.index')  :  Defender::createPermission('lawsTags.index','Ver tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsTags.edit') ? Defender::findPermission('lawsTags.edit')  :  Defender::createPermission('lawsTags.edit','Editar tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsTags.delete') ? Defender::findPermission('lawsTags.delete')  :  Defender::createPermission('lawsTags.delete','Excluir tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsTags.show') ? Defender::findPermission('lawsTags.show')  :  Defender::createPermission('lawsTags.show','Detalhe tag de lei');

        $perm['company'][] = Defender::permissionExists('lawsProjects.create') ? Defender::findPermission('lawsProjects.create')  :  Defender::createPermission('lawsProjects.create','Criar tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsProjects.index') ? Defender::findPermission('lawsProjects.index')  :  Defender::createPermission('lawsProjects.index','Ver tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsProjects.edit') ? Defender::findPermission('lawsProjects.edit')  :  Defender::createPermission('lawsProjects.edit','Editar tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsProjects.delete') ? Defender::findPermission('lawsProjects.delete')  :  Defender::createPermission('lawsProjects.delete','Excluir tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsProjects.show') ? Defender::findPermission('lawsProjects.show')  :  Defender::createPermission('lawsProjects.show','Detalhe tag de lei');
        $perm['company'][] = Defender::permissionExists('lawsProjects.upload') ? Defender::findPermission('lawsProjects.upload')  :  Defender::createPermission('lawsProjects.upload','Permite upload no projeto de lei');

        $perm['company'][] = Defender::permissionExists('lawSituations.create') ? Defender::findPermission('lawSituations.create')  :  Defender::createPermission('lawSituations.create','Criar situacao de lei');
        $perm['company'][] = Defender::permissionExists('lawSituations.index') ? Defender::findPermission('lawSituations.index')  :  Defender::createPermission('lawSituations.index','Ver situacao de lei');
        $perm['company'][] = Defender::permissionExists('lawSituations.edit') ? Defender::findPermission('lawSituations.edit')  :  Defender::createPermission('lawSituations.edit','Editar situacao de lei');
        $perm['company'][] = Defender::permissionExists('lawSituations.delete') ? Defender::findPermission('lawSituations.delete')  :  Defender::createPermission('lawSituations.delete','Excluir situacao de lei');
        $perm['company'][] = Defender::permissionExists('lawSituations.show') ? Defender::findPermission('lawSituations.show')  :  Defender::createPermission('lawSituations.show','Detalhe situacao de lei');

        $perm['company'][] = Defender::permissionExists('structurepautas.create') ? Defender::findPermission('structurepautas.create')  :  Defender::createPermission('structurepautas.create','Criar estrutura de pauta');
        $perm['company'][] = Defender::permissionExists('structurepautas.index') ? Defender::findPermission('structurepautas.index')  :  Defender::createPermission('structurepautas.index','Ver estrutura de pauta');
        $perm['company'][] = Defender::permissionExists('structurepautas.edit') ? Defender::findPermission('structurepautas.edit')  :  Defender::createPermission('structurepautas.edit','Editar estrutura de pauta');
        $perm['company'][] = Defender::permissionExists('structurepautas.delete') ? Defender::findPermission('structurepautas.delete')  :  Defender::createPermission('structurepautas.delete','Excluir estrutura de pauta');
        $perm['company'][] = Defender::permissionExists('structurepautas.show') ? Defender::findPermission('structurepautas.show')  :  Defender::createPermission('structurepautas.show','Detalhe estrutura de pauta');

        $perm['company'][] = Defender::permissionExists('comissionSituations.create') ? Defender::findPermission('comissionSituations.create')  :  Defender::createPermission('comissionSituations.create','Criar situacao de parecer');
        $perm['company'][] = Defender::permissionExists('comissionSituations.index') ? Defender::findPermission('comissionSituations.index')  :  Defender::createPermission('comissionSituations.index','Ver situacao de parecer');
        $perm['company'][] = Defender::permissionExists('comissionSituations.edit') ? Defender::findPermission('comissionSituations.edit')  :  Defender::createPermission('comissionSituations.edit','Editar situacao de parecer');
        $perm['company'][] = Defender::permissionExists('comissionSituations.delete') ? Defender::findPermission('comissionSituations.delete')  :  Defender::createPermission('comissionSituations.delete','Excluir situacao de parecer');
        $perm['company'][] = Defender::permissionExists('comissionSituations.show') ? Defender::findPermission('comissionSituations.show')  :  Defender::createPermission('comissionSituations.show','Detalhe situacao de parecer');

        $perm['company'][] = Defender::permissionExists('adviceSituationLaws.create') ? Defender::findPermission('adviceSituationLaws.create')  :  Defender::createPermission('adviceSituationLaws.create','Criar situacao de parecer de lei');
        $perm['company'][] = Defender::permissionExists('adviceSituationLaws.index') ? Defender::findPermission('adviceSituationLaws.index')  :  Defender::createPermission('adviceSituationLaws.index','Ver situacao de parecer de lei');
        $perm['company'][] = Defender::permissionExists('adviceSituationLaws.edit') ? Defender::findPermission('adviceSituationLaws.edit')  :  Defender::createPermission('adviceSituationLaws.edit','Editar situacao de parecer de lei');
        $perm['company'][] = Defender::permissionExists('adviceSituationLaws.delete') ? Defender::findPermission('adviceSituationLaws.delete')  :  Defender::createPermission('adviceSituationLaws.delete','Excluir situacao de parecer de lei');
        $perm['company'][] = Defender::permissionExists('adviceSituationLaws.show') ? Defender::findPermission('adviceSituationLaws.show')  :  Defender::createPermission('adviceSituationLaws.show','Detalhe situacao de parecer de lei');

        $perm['company'][] = Defender::permissionExists('advicePublicationLaws.create') ? Defender::findPermission('advicePublicationLaws.create')  :  Defender::createPermission('advicePublicationLaws.create','Criar publicação de parecer de lei');
        $perm['company'][] = Defender::permissionExists('advicePublicationLaws.index') ? Defender::findPermission('advicePublicationLaws.index')  :  Defender::createPermission('advicePublicationLaws.index','Ver publicação de parecer de lei');
        $perm['company'][] = Defender::permissionExists('advicePublicationLaws.edit') ? Defender::findPermission('advicePublicationLaws.edit')  :  Defender::createPermission('advicePublicationLaws.edit','Editar publicação de parecer de lei');
        $perm['company'][] = Defender::permissionExists('advicePublicationLaws.delete') ? Defender::findPermission('advicePublicationLaws.delete')  :  Defender::createPermission('advicePublicationLaws.delete','Excluir publicação de parecer de lei');
        $perm['company'][] = Defender::permissionExists('advicePublicationLaws.show') ? Defender::findPermission('advicePublicationLaws.show')  :  Defender::createPermission('advicePublicationLaws.show','Detalhe publicação de parecer de lei');

        $perm['company'][] = Defender::permissionExists('adviceSituationDocuments.create') ? Defender::findPermission('adviceSituationDocuments.create')  :  Defender::createPermission('adviceSituationDocuments.create','Criar situacao de parecer de documento');
        $perm['company'][] = Defender::permissionExists('adviceSituationDocuments.index') ? Defender::findPermission('adviceSituationDocuments.index')  :  Defender::createPermission('adviceSituationDocuments.index','Ver situacao de parecer de documento');
        $perm['company'][] = Defender::permissionExists('adviceSituationDocuments.edit') ? Defender::findPermission('adviceSituationDocuments.edit')  :  Defender::createPermission('adviceSituationDocuments.edit','Editar situacao de parecer de documento');
        $perm['company'][] = Defender::permissionExists('adviceSituationDocuments.delete') ? Defender::findPermission('adviceSituationDocuments.delete')  :  Defender::createPermission('adviceSituationDocuments.delete','Excluir situacao de parecer de documento');
        $perm['company'][] = Defender::permissionExists('adviceSituationDocuments.show') ? Defender::findPermission('adviceSituationDocuments.show')  :  Defender::createPermission('adviceSituationDocuments.show','Detalhe situacao de parecer de documento');

        $perm['company'][] = Defender::permissionExists('advicePublicationDocuments.create') ? Defender::findPermission('advicePublicationDocuments.create')  :  Defender::createPermission('advicePublicationDocuments.create','Criar publicação de parecer de documento');
        $perm['company'][] = Defender::permissionExists('advicePublicationDocuments.index') ? Defender::findPermission('advicePublicationDocuments.index')  :  Defender::createPermission('advicePublicationDocuments.index','Ver publicação de parecer de documento');
        $perm['company'][] = Defender::permissionExists('advicePublicationDocuments.edit') ? Defender::findPermission('advicePublicationDocuments.edit')  :  Defender::createPermission('advicePublicationDocuments.edit','Editar publicação de parecer de documento');
        $perm['company'][] = Defender::permissionExists('advicePublicationDocuments.delete') ? Defender::findPermission('advicePublicationDocuments.delete')  :  Defender::createPermission('advicePublicationDocuments.delete','Excluir publicação de parecer de documento');
        $perm['company'][] = Defender::permissionExists('advicePublicationDocuments.show') ? Defender::findPermission('advicePublicationDocuments.show')  :  Defender::createPermission('advicePublicationDocuments.show','Detalhe publicação de parecer de documento');

        $perm['company'][] = Defender::permissionExists('statusProcessingLaws.create') ? Defender::findPermission('statusProcessingLaws.create')  :  Defender::createPermission('statusProcessingLaws.create','Criar status do tramite de lei');
        $perm['company'][] = Defender::permissionExists('statusProcessingLaws.index') ? Defender::findPermission('statusProcessingLaws.index')  :  Defender::createPermission('statusProcessingLaws.index','Ver status do tramite de lei');
        $perm['company'][] = Defender::permissionExists('statusProcessingLaws.edit') ? Defender::findPermission('statusProcessingLaws.edit')  :  Defender::createPermission('statusProcessingLaws.edit','Editar status do tramite de lei');
        $perm['company'][] = Defender::permissionExists('statusProcessingLaws.delete') ? Defender::findPermission('statusProcessingLaws.delete')  :  Defender::createPermission('statusProcessingLaws.delete','Excluir status do tramite de lei');
        $perm['company'][] = Defender::permissionExists('statusProcessingLaws.show') ? Defender::findPermission('statusProcessingLaws.show')  :  Defender::createPermission('statusProcessingLaws.show','Detalhe status do tramite de lei');

        $perm['company'][] = Defender::permissionExists('statusProcessingDocuments.create') ? Defender::findPermission('statusProcessingDocuments.create')  :  Defender::createPermission('statusProcessingDocuments.create','Criar status do tramite de documento');
        $perm['company'][] = Defender::permissionExists('statusProcessingDocuments.index') ? Defender::findPermission('statusProcessingDocuments.index')  :  Defender::createPermission('statusProcessingDocuments.index','Ver status do tramite de documento');
        $perm['company'][] = Defender::permissionExists('statusProcessingDocuments.edit') ? Defender::findPermission('statusProcessingDocuments.edit')  :  Defender::createPermission('statusProcessingDocuments.edit','Editar status do tramite de documento');
        $perm['company'][] = Defender::permissionExists('statusProcessingDocuments.delete') ? Defender::findPermission('statusProcessingDocuments.delete')  :  Defender::createPermission('statusProcessingDocuments.delete','Excluir status do tramite de documento');
        $perm['company'][] = Defender::permissionExists('statusProcessingDocuments.show') ? Defender::findPermission('statusProcessingDocuments.show')  :  Defender::createPermission('statusProcessingDocuments.show','Detalhe status do tramite de documento');

        $perm['company'][] = Defender::permissionExists('typeVotings.create') ? Defender::findPermission('typeVotings.create')  :  Defender::createPermission('typeVotings.create','Criar tipo de vontação');
        $perm['company'][] = Defender::permissionExists('typeVotings.index') ? Defender::findPermission('typeVotings.index')  :  Defender::createPermission('typeVotings.index','Ver status do tipo de vontação');
        $perm['company'][] = Defender::permissionExists('typeVotings.edit') ? Defender::findPermission('typeVotings.edit')  :  Defender::createPermission('typeVotings.edit','Editar tipo de vontação');
        $perm['company'][] = Defender::permissionExists('typeVotings.delete') ? Defender::findPermission('typeVotings.delete')  :  Defender::createPermission('typeVotings.delete','Excluir status do tipo de vontação');
        $perm['company'][] = Defender::permissionExists('typeVotings.show') ? Defender::findPermission('typeVotings.show')  :  Defender::createPermission('typeVotings.show','Detalhe do tipo de vontação');

        $perm['company'][] = Defender::permissionExists('version_pauta.create') ? Defender::findPermission('version_pauta.create')  :  Defender::createPermission('version_pauta.create','Criar tipo de versão de pauta');
        $perm['company'][] = Defender::permissionExists('version_pauta.index') ? Defender::findPermission('version_pauta.index')  :  Defender::createPermission('version_pauta.index','Ver status do tipo de versão de pauta');
        $perm['company'][] = Defender::permissionExists('version_pauta.edit') ? Defender::findPermission('version_pauta.edit')  :  Defender::createPermission('version_pauta.edit','Editar tipo de versão de pauta');
        $perm['company'][] = Defender::permissionExists('version_pauta.delete') ? Defender::findPermission('version_pauta.delete')  :  Defender::createPermission('version_pauta.delete','Excluir status do tipo de versão de pauta');
        $perm['company'][] = Defender::permissionExists('version_pauta.show') ? Defender::findPermission('version_pauta.show')  :  Defender::createPermission('version_pauta.show','Detalhe do tipo de versão de pauta');


        //Permissões especiais
        $perm['readDocument'][]     = Defender::permissionExists('document.read') ? Defender::findPermission('document.read')  :  Defender::createPermission('document.read','Mudar documento leitura');
        $perm['approvedDocument'][] = Defender::permissionExists('document.approved') ? Defender::findPermission('document.approved')  :  Defender::createPermission('document.approved','Mudar documento aprovação');

        $perm['readLawsProject'][]      = Defender::permissionExists('lawsProject.read') ? Defender::findPermission('lawsProject.read')  :  Defender::createPermission('lawsProject.read','Mudar projeto de lei leitura');
        $perm['approvedLawsProject'][]  = Defender::permissionExists('lawsProject.approved') ? Defender::findPermission('lawsProject.approved')  :  Defender::createPermission('lawsProject.approved','Mudar projeto de lei aprovação');
        $perm['solicitaParecer'][]      = Defender::permissionExists('lawsProject.advices') ? Defender::findPermission('lawsProject.advices')  :  Defender::createPermission('lawsProject.advices','Pode pedir parecer');
        $perm['solicitaParecerEditar'][]      = Defender::permissionExists('lawsProject.advicesEdit') ? Defender::findPermission('lawsProject.advicesEdit')  :  Defender::createPermission('lawsProject.advicesEdit','Pode editar pedido de parecer');
        $perm['solicitaParecerDeletar'][]      = Defender::permissionExists('lawsProject.advicesDelete') ? Defender::findPermission('lawsProject.advicesDelete')  :  Defender::createPermission('lawsProject.advicesDelete','Pode deletar pedido de parecer');
        $perm['solicitaParecerDeletarArquivo'][]      = Defender::permissionExists('lawsProject.advicesDeleteFile') ? Defender::findPermission('lawsProject.advicesDeleteFile')  :  Defender::createPermission('lawsProject.advicesDeleteFile','Pode deletar arquivo pedido de parecer');
        $perm['solicitaParecerDocumento'][]      = Defender::permissionExists('documents.advices') ? Defender::findPermission('documents.advices')  :  Defender::createPermission('documents.advices','Pode pedir parecer documento');

        $perm['editaProtocoloDocumento'][]      = Defender::permissionExists('document.editprotocol') ? Defender::findPermission('document.editprotocol')  :  Defender::createPermission('document.editprotocol','Pode editar protocolo de um documento');
        $perm['editaNumeroDocumento'][]      = Defender::permissionExists('document.editnumero') ? Defender::findPermission('document.editnumero')  :  Defender::createPermission('document.editnumero','Pode editar numero de um documento');

        $perm['editaProtocoloLei'][]      = Defender::permissionExists('lawsProject.editprotocollei') ? Defender::findPermission('lawsProject.editprotocollei')  :  Defender::createPermission('lawsProject.editprotocollei','Pode editar protocolo de uma lei');
        $perm['editaNumeroLei'][]      = Defender::permissionExists('lawsProject.editnumerolei') ? Defender::findPermission('lawsProject.editnumerolei')  :  Defender::createPermission('lawsProject.editnumerolei','Pode editar numero de uma lei');
        $perm['editaNumeroAprovacao'][]      = Defender::permissionExists('lawProject.approvedEdit') ? Defender::findPermission('lawProject.approvedEdit')  :  Defender::createPermission('lawProject.approvedEdit','Pode editar numero de aprovação de uma lei');



        /*
         *  ATIVAR PERMISSOES PADRAO
         */
        foreach($perm['root'] as $item){
            $roleRoot->attachPermission($item);
        }
        foreach($perm['company'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
        }

        foreach($perm['approvedDocument'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
            $roleApprovedDocument->attachPermission($item);
        }

        foreach($perm['readDocument'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
            $roleReadDocument->attachPermission($item);
        }

        foreach($perm['approvedLawsProject'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
            $roleApprovedLawsProject->attachPermission($item);
        }

        foreach($perm['readLawsProject'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
            $roleReadLawsProject->attachPermission($item);
        }

        foreach($perm['solicitaParecer'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
            $rolePodePedirParecer->attachPermission($item);
        }

        foreach($perm['solicitaParecerEditar'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
            $rolePodePedirParecer->attachPermission($item);
        }

        foreach($perm['solicitaParecerDeletar'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
            $rolePodePedirParecer->attachPermission($item);
        }

        foreach($perm['solicitaParecerDeletarArquivo'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
            $rolePodePedirParecer->attachPermission($item);
        }


        foreach($perm['editaProtocoloDocumento'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
        }

        foreach($perm['editaNumeroDocumento'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
        }

        foreach($perm['editaProtocoloLei'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
        }

        foreach($perm['editaNumeroLei'] as $item){
            $roleRoot->attachPermission($item);
            $roleAdmin->attachPermission($item);
        }

    }
}
