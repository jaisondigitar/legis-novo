<?php
// home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Dashboard', "/");
});

/*
 *  COMPANIES
 */

Breadcrumbs::register('company.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Configurações', null);
    $breadcrumbs->push('Empresas', "/config/companies");
});
Breadcrumbs::register('company.new', function($breadcrumbs)
{
    $breadcrumbs->parent('company.list');
    $breadcrumbs->push('Nova Empresa', null);
});
Breadcrumbs::register('company.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('company.list');
    $breadcrumbs->push('Editar Empresa', null);
});
Breadcrumbs::register('company.show', function($breadcrumbs)
{
    $breadcrumbs->parent('company.list');
    $breadcrumbs->push('Empresa', null);
});

/*
 * USERS
 */

Breadcrumbs::register('users.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Usuários', "/users");
});
Breadcrumbs::register('users.new', function($breadcrumbs)
{
    $breadcrumbs->parent('users.list');
    $breadcrumbs->push('Novo usuário', "/users/create");
});
Breadcrumbs::register('users.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('users.list');
    $breadcrumbs->push('Editar Usuario', null);
});
Breadcrumbs::register('users.show', function($breadcrumbs)
{
    $breadcrumbs->parent('users.list');
    $breadcrumbs->push('Usuario', null);
});

/*
 * LEGISLATURE
 */

Breadcrumbs::register('legislatures.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Legislaturas', "/legislatures");
});
Breadcrumbs::register('legislatures.new', function($breadcrumbs)
{
    $breadcrumbs->parent('legislatures.list');
    $breadcrumbs->push('Nova Legislatura', "/legislatures/create");
});
Breadcrumbs::register('legislatures.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('legislatures.list');
    $breadcrumbs->push('Editar Legislatura', null);
});
Breadcrumbs::register('legislatures.show', function($breadcrumbs)
{
    $breadcrumbs->parent('legislatures.list');
    $breadcrumbs->push('Legislatura', null);
});

/*
 * PARTIES
 */

Breadcrumbs::register('parties.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Partidos', "/parties");
});
Breadcrumbs::register('parties.new', function($breadcrumbs)
{
    $breadcrumbs->parent('parties.list');
    $breadcrumbs->push('Novo partido', "/parties/create");
});
Breadcrumbs::register('parties.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('parties.list');
    $breadcrumbs->push('Editar Partido', null);
});
Breadcrumbs::register('parties.show', function($breadcrumbs)
{
    $breadcrumbs->parent('parties.list');
    $breadcrumbs->push('Partido', null);
});


/*
 * RESPONSIBILITIES
 */

Breadcrumbs::register('responsibilities.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Responsabilidades', "/responsibilities");
});
Breadcrumbs::register('responsibilities.new', function($breadcrumbs)
{
    $breadcrumbs->parent('responsibilities.list');
    $breadcrumbs->push('Novo Responsabilidade', "/responsibilities/create");
});
Breadcrumbs::register('responsibilities.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('responsibilities.list');
    $breadcrumbs->push('Editar Responsabilidade', null);
});
Breadcrumbs::register('responsibilities.show', function($breadcrumbs)
{
    $breadcrumbs->parent('responsibilities.list');
    $breadcrumbs->push('Responsabilidade', null);
});

/*
 * ASSEMBLYMEN
 */

Breadcrumbs::register('assemblymen.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Parlamentares', "/assemblymen");
});
Breadcrumbs::register('assemblymen.new', function($breadcrumbs)
{
    $breadcrumbs->parent('assemblymen.list');
    $breadcrumbs->push('Novo Parlamentar', "/assemblymen/create");
});
Breadcrumbs::register('assemblymen.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('assemblymen.list');
    $breadcrumbs->push('Editar Parlamentar', null);
});
Breadcrumbs::register('assemblymen.show', function($breadcrumbs)
{
    $breadcrumbs->parent('assemblymen.list');
    $breadcrumbs->push('Parlamentar', null);
});

/*
 * SECTOR
 */

Breadcrumbs::register('sectors.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Setores', "/sectors");
});
Breadcrumbs::register('sectors.new', function($breadcrumbs)
{
    $breadcrumbs->parent('sectors.list');
    $breadcrumbs->push('Novo Setor', "/sectors/create");
});
Breadcrumbs::register('sectors.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('sectors.list');
    $breadcrumbs->push('Editar Setor', null);
});
Breadcrumbs::register('sectors.show', function($breadcrumbs)
{
    $breadcrumbs->parent('sectors.list');
    $breadcrumbs->push('Setor', null);
});

/*
 * DOCUMENT MODELS
 */

Breadcrumbs::register('documentModels.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Modelos de Documentos', "/documentModels");
});
Breadcrumbs::register('documentModels.new', function($breadcrumbs)
{
    $breadcrumbs->parent('documentModels.list');
    $breadcrumbs->push('Novo Modelo de Documentos', "/documentModels/create");
});
Breadcrumbs::register('documentModels.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('documentModels.list');
    $breadcrumbs->push('Editar Modelo de Documentos', null);
});
Breadcrumbs::register('documentModels.show', function($breadcrumbs)
{
    $breadcrumbs->parent('documentModels.list');
    $breadcrumbs->push('Modelo de Documentos', null);
});


/*
 * DOCUMENT TYPE
 */

Breadcrumbs::register('documentTypes.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipos de Documentos', "/documentTypes");
});
Breadcrumbs::register('documentTypes.new', function($breadcrumbs)
{
    $breadcrumbs->parent('documentTypes.list');
    $breadcrumbs->push('Novo Tipo de Documento', "/documentTypes/create");
});
Breadcrumbs::register('documentTypes.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('documentTypes.list');
    $breadcrumbs->push('Editar Tipo de Documento', null);
});
Breadcrumbs::register('documentTypes.show', function($breadcrumbs)
{
    $breadcrumbs->parent('documentTypes.list');
    $breadcrumbs->push('Tipo de Documentos', null);
});

/*
 * DOCUMENT SITUATION
 */
Breadcrumbs::register('documentSituations.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Situação do Documentos', "/documentSituations");
});
Breadcrumbs::register('documentSituations.new', function($breadcrumbs)
{
    $breadcrumbs->parent('documentSituations.list');
    $breadcrumbs->push('Nova Situação do Documentos', "/documentSituations/create");
});
Breadcrumbs::register('documentSituations.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('documentSituations.list');
    $breadcrumbs->push('Editar Situação do Documentos', null);
});
Breadcrumbs::register('documentSituations.show', function($breadcrumbs)
{
    $breadcrumbs->parent('documentSituations.list');
    $breadcrumbs->push('Situação de Documentos', null);
});

/*
 * PROTOCOL TYPE
 */

Breadcrumbs::register('protocolTypes.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipos de Protocolos', "/protocolTypes");
});
Breadcrumbs::register('protocolTypes.new', function($breadcrumbs)
{
    $breadcrumbs->parent('protocolTypes.list');
    $breadcrumbs->push('Novo Tipo de Protocolo', "/protocolTypes/create");
});
Breadcrumbs::register('protocolTypes.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('protocolTypes.list');
    $breadcrumbs->push('Editar Tipo de Protocolo', null);
});
Breadcrumbs::register('protocolTypes.show', function($breadcrumbs)
{
    $breadcrumbs->parent('protocolTypes.list');
    $breadcrumbs->push('Tipo de Protocolo', null);
});

/*
 * DOCUMENT
 */

Breadcrumbs::register('documents.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Documentos', "/documents");
});
Breadcrumbs::register('documents.new', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.list');
    $breadcrumbs->push('Novo Documento', "/documents/create");
});
Breadcrumbs::register('documents.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.list');
    $breadcrumbs->push('Editar Documento', null);
});
Breadcrumbs::register('documents.show', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.list');
    $breadcrumbs->push('Documento', null);
});

Breadcrumbs::register('documents.attachment', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.list');
    $breadcrumbs->push('Anexos documento', null);
});

/*
 * COMMISSION
 */

Breadcrumbs::register('commissions.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Comissões', "/commissions");
});
Breadcrumbs::register('commissions.new', function($breadcrumbs)
{
    $breadcrumbs->parent('commissions.list');
    $breadcrumbs->push('Nova Comissão', "/commissions/create");
});
Breadcrumbs::register('commissions.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('commissions.list');
    $breadcrumbs->push('Editar Comissão', null);
});
Breadcrumbs::register('commissions.show', function($breadcrumbs)
{
    $breadcrumbs->parent('commissions.list');
    $breadcrumbs->push('Comissão', null);
});

/*
 * OFFICE COMMISSION
 */


Breadcrumbs::register('officeCommission.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Cargos de Comissão', "/officeCommissions");
});
Breadcrumbs::register('officeCommission.new', function($breadcrumbs)
{
    $breadcrumbs->parent('officeCommission.list');
    $breadcrumbs->push('Novo Cargo de Comissão', "/officeCommissions/create");
});
Breadcrumbs::register('officeCommission.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('officeCommission.list');
    $breadcrumbs->push('Editar Cargo de Comissão', null);
});
Breadcrumbs::register('officeCommission.show', function($breadcrumbs)
{
    $breadcrumbs->parent('officeCommission.list');
    $breadcrumbs->push('Cargo de Comissão', null);
});

/*
 * PARAMETERS
 */


Breadcrumbs::register('parameters.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Parâmetro', "/parameters");
});
Breadcrumbs::register('parameters.new', function($breadcrumbs)
{
    $breadcrumbs->parent('parameters.list');
    $breadcrumbs->push('Novo Parâmetro', "/parameters/create");
});
Breadcrumbs::register('parameters.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('parameters.list');
    $breadcrumbs->push('Editar Parâmetro', null);
});
Breadcrumbs::register('parameters.show', function($breadcrumbs)
{
    $breadcrumbs->parent('parameters.list');
    $breadcrumbs->push('Parâmetro', null);
});


/*
 * SESSION_TYPES
 */

Breadcrumbs::register('sessionTypes.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipo de Sessão', "/sessionTypes");
});
Breadcrumbs::register('sessionTypes.new', function($breadcrumbs)
{
    $breadcrumbs->parent('sessionTypes.list');
    $breadcrumbs->push('Novo Tipo de Sessão', "/sessionTypes/create");
});
Breadcrumbs::register('sessionTypes.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('sessionTypes.list');
    $breadcrumbs->push('Editar Tipo de Sessão', null);
});
Breadcrumbs::register('sessionTypes.show', function($breadcrumbs)
{
    $breadcrumbs->parent('sessionTypes.list');
    $breadcrumbs->push('Tipo de Sessão', null);
});



/*
 * SESSION_PLACES
 */

Breadcrumbs::register('sessionPlaces.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Locais de Sessão', "/sessionPlaces");
});
Breadcrumbs::register('sessionPlaces.new', function($breadcrumbs)
{
    $breadcrumbs->parent('sessionPlaces.list');
    $breadcrumbs->push('Novo Local de Sessão', "/sessionPlaces/create");
});
Breadcrumbs::register('sessionPlaces.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('sessionPlaces.list');
    $breadcrumbs->push('Editar Local de Sessão', null);
});
Breadcrumbs::register('sessionPlaces.show', function($breadcrumbs)
{
    $breadcrumbs->parent('sessionPlaces.list');
    $breadcrumbs->push('Local de Sessão', null);
});

/*
 * MEETINGS
 */

Breadcrumbs::register('meetings.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Sessões', "/meetings");
});
Breadcrumbs::register('meetings.new', function($breadcrumbs)
{
    $breadcrumbs->parent('meetings.list');
    $breadcrumbs->push('Nova Sessão', "/meetings/create");
});
Breadcrumbs::register('meetings.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('meetings.list');
    $breadcrumbs->push('Editar Sessão', null);
});
Breadcrumbs::register('meetings.show', function($breadcrumbs)
{
    $breadcrumbs->parent('meetings.list');
    $breadcrumbs->push('Sessão', null);
});
Breadcrumbs::register('meetings.attachment', function($breadcrumbs)
{
    $breadcrumbs->parent('meetings.list');
    $breadcrumbs->push('Anexos documento', null);
});

/*
 * LAWS TYPES
 */

Breadcrumbs::register('lawsTypes.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipos de lei', "/lawsTypes");
});
Breadcrumbs::register('lawsTypes.new', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsTypes.list');
    $breadcrumbs->push('Novo tipo de lei', "/lawsTypes/create");
});
Breadcrumbs::register('lawsTypes.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsTypes.list');
    $breadcrumbs->push('Editar tipo de lei', null);
});
Breadcrumbs::register('lawsTypes.show', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsTypes.list');
    $breadcrumbs->push('Tipo de lei', null);
});

/*
 * LAWS PLACES
 */

Breadcrumbs::register('lawsPlaces.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Locais de publicação', "/lawsPlaces");
});
Breadcrumbs::register('lawsPlaces.new', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsPlaces.list');
    $breadcrumbs->push('Novo local de publicação', "/lawsPlaces/create");
});
Breadcrumbs::register('lawsPlaces.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsPlaces.list');
    $breadcrumbs->push('Editar local de publicação', null);
});
Breadcrumbs::register('lawsPlaces.show', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsPlaces.list');
    $breadcrumbs->push('Local de publicação', null);
});


/*
 * LAWS Structure
 */

Breadcrumbs::register('lawsStructures.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipos de estrutura', "/lawsStructures");
});
Breadcrumbs::register('lawsStructures.new', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsStructures.list');
    $breadcrumbs->push('Novo tipo de estrutura', "/lawsStructures/create");
});
Breadcrumbs::register('lawsStructures.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsStructures.list');
    $breadcrumbs->push('Editar tipo de estrutura', null);
});
Breadcrumbs::register('lawsStructures.show', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsStructures.list');
    $breadcrumbs->push('Tipo de estrutura', null);
});


/*
 * LAWS TAGS
 */

Breadcrumbs::register('lawsTags.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tags de lei', "/lawsTags");
});
Breadcrumbs::register('lawsTags.new', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsTags.list');
    $breadcrumbs->push('Nova tag de lei', "/lawsTags/create");
});
Breadcrumbs::register('lawsTags.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsTags.list');
    $breadcrumbs->push('Editar tag de lei', null);
});
Breadcrumbs::register('lawsTags.show', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsTags.list');
    $breadcrumbs->push('Tag de lei', null);
});

/*
 * LAWS PROJECT
 */

Breadcrumbs::register('lawsProjects.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Projetos de Lei', "/lawsProjects");
});
Breadcrumbs::register('lawsProjects.new', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsProjects.list');
    $breadcrumbs->push('Novo projeto de lei', "/lawsProjects/create");
});
Breadcrumbs::register('lawsProjects.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsProjects.list');
    $breadcrumbs->push('Editar projeto de lei', null);
});
Breadcrumbs::register('lawsProjects.show', function($breadcrumbs)
{
    $breadcrumbs->parent('lawsProjects.list');
    $breadcrumbs->push('Projeto de lei', null);
});

/*
 * LAWS PROJECT SITUATION ADVICES
 */

Breadcrumbs::register('adviceSituationLaws.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Situação do parecer da lei', "/adviceSituationLaws");
});
Breadcrumbs::register('adviceSituationLaws.new', function($breadcrumbs)
{
    $breadcrumbs->parent('adviceSituationLaws.list');
    $breadcrumbs->push('Nova situação de parecer da lei', "/adviceSituationLaws/create");
});
Breadcrumbs::register('adviceSituationLaws.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('adviceSituationLaws.list');
    $breadcrumbs->push('Editar situação de parecer da lei', null);
});
Breadcrumbs::register('adviceSituationLaws.show', function($breadcrumbs)
{
    $breadcrumbs->parent('adviceSituationLaws.list');
    $breadcrumbs->push('situação de parecer da lei', null);
});

/*
 * LAWS PROJECT SITUATION ADVICES
 */

Breadcrumbs::register('advicePublicationLaws.list', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Publicação do parecer da lei', "/advicePublicationLaws");
});
Breadcrumbs::register('advicePublicationLaws.new', function($breadcrumbs)
{
    $breadcrumbs->parent('advicePublicationLaws.list');
    $breadcrumbs->push('Nova publicação de parecer da lei', "/advicePublicationLaws/create");
});
Breadcrumbs::register('advicePublicationLaws.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('advicePublicationLaws.list');
    $breadcrumbs->push('Editar publicação de parecer da lei', null);
});
Breadcrumbs::register('advicePublicationLaws.show', function($breadcrumbs)
{
    $breadcrumbs->parent('advicePublicationLaws.list');
    $breadcrumbs->push('publicação de parecer da lei', null);
});